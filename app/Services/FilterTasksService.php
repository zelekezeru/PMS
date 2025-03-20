<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Fortnight;
use App\Models\Day;

class FilterTasksService
{
  /**
   * 
   * Filters tasks base on the received $tasks and $requested
   * 
   * this function can filter using search, status and due_date
   * 
   */
  public function filterByColumns($tasks, $request)
  {
    
    $search = $request->query('search') ?? null;

    $status = $request->query('status') ?? null;

    $dueDays = is_numeric($request->query('due_days')) ? intval($request->query('due_days')) : null;

    $order = strtolower($request->query('order'));

    //Search Filter
    if ($search) {

      // This is a grouped query that lets the function search from task name and also their creator name
      $tasks = $tasks->where(function ($query) use ($search) {

        $query->where('name', 'LIKE', '%' . $search . '%')
          ->orWhereHas('createdBy', function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%');
          });
      });
    }

    // This filters The tasks based on Status
    if ($status) {
      $tasks = $tasks->where('status', $status);
    }

    // This filters based on how many days is left before task expires (based on due date)
    if ($dueDays) {
      $dueDate = Carbon::now()->addDays($dueDays)->toDateString();
      $tasks = $tasks->whereNotNull('due_date')->whereDate('due_date', '<=', $dueDate);
    }

    // This adjusts the orders based on the name of the tasks
    if (in_array($order, ['asc', 'desc'])) {
      $tasks = $tasks->orderBy('name', $order);
    }

    // Return The query builder to the caller
    return $tasks;
  }

  /**
   * 
   * This Function is what enables us to filter currentFortnights or Daily Tasks
   * 
   */

  public function filterByScope($tasks, $request)
  {
    $today = Carbon::now()->format('Y-m-d');

    $currentFortnight = $request->query('currentFortnight') || $request->query('onlyToday') ? Fortnight::whereDate('start_date', '<=', $today)
    ->whereDate('end_date', '>=', $today)->first() : null;
    /**
     * If There is ?currentFortnight=1 in the url we fetch the tasks of the current fortnight
     * If There is ?onlyToday=1 in the url we fetch the tasks of the current day
     */
    if ($request->query('currentFortnight')) {
      $tasks = $tasks->whereHas('fortnights', function ($query) use ($currentFortnight) {
        $query->where('fortnights.id', $currentFortnight->id);
      });
    } elseif ($request->query('onlyToday')) {

      // Check if the day exists and if it doesnt create the day
      if (Day::where('date', $today)->exists()) {
        $day = Day::where('date', $today)->first()->id;
      } else {
        $day = Day::create([
          'fortnight_id' => $currentFortnight->id,
          'date' => $today
        ])->id;
      }
      $tasks = $tasks->whereHas('days', function ($query) use ($day) {
        $query->where('days.id', $day);
      });
    }

    // Return the query builder
    return [$tasks, $currentFortnight];
  }
}
