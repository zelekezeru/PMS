<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Accept a date query parameter (YYYY-MM-DD). Default to today.
        $date = request()->query('date', now()->format('Y-m-d'));

        $selectedDate = isset($date) ? Carbon::parse($date)->format('Y-m-d') : now()->format('Y-m-d');

        $userId = request()->query('user_id');

        $query = DailyTask::with('user')->whereDate('date', $date);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $dailyTasks = $query->orderBy('created_at', 'desc')->get();

        // Summary counts
        $total = $dailyTasks->count();
        $completed = $dailyTasks->where('status', 'Completed')->count();
        $inProgress = $dailyTasks->where('status', 'In Progress')->count();
        $pending = $dailyTasks->where('status', 'Pending')->count();
        // Overdue = tasks not completed with date < today
        $overdue = DailyTask::whereDate('date', '<', now()->format('Y-m-d'))
                    ->where('status', '!=', 'Completed')
                    ->when($userId, fn($q) => $q->where('user_id', $userId))
                    ->count();

        // User list for filter
        $users = \App\Models\User::orderBy('name')->get();

        return view('daily_tasks.index', compact('dailyTasks', 'date', 'selectedDate', 'users', 'total', 'completed', 'inProgress', 'pending', 'overdue'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //create daily task is handled in TaskController
        $dailyTask = new DailyTask();

        $users = User::orderBy('name')->get();

        return view('daily_tasks.create', compact('dailyTask', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        DailyTask::create($validated);

        return redirect()->route('daily_tasks.index', ['date' => $validated['date']])->with('success', 'Daily Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyTask $dailyTask)
    {
        return view('daily_tasks.show', compact('dailyTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyTask $dailyTask)
    {
        $users = User::orderBy('name')->get();

        return view('daily_tasks.edit', compact('dailyTask', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyTask $dailyTask)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $dailyTask->update($validated);

        return redirect()->route('daily_tasks.show', $dailyTask)->with('success', 'Daily Task updated successfully.');
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(Request $request, DailyTask $dailyTask)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $dailyTask->update($validated);

        return redirect()->route('daily_tasks.show', $dailyTask)->with('success', 'Daily Task status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyTask $dailyTask)
    {
        $user = $dailyTask->user;

        $dailyTask->delete();

        if ($user) {
            return redirect()->route('users.show', $user)->with('success', 'Daily Task deleted successfully.');
        }

        return redirect()->route('daily_tasks.index')->with('success', 'Daily Task deleted successfully.');
    }
}
