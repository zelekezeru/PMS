<?php

namespace App\Http\Controllers;

use App\Models\Fortnight;
use App\Models\Quarter;
use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Services\FilterTasksService;
use Illuminate\Http\Request;

class FortnightController extends Controller
{
    // Display a listing of the fortnights
    public function index()
    {
        $fortnights = Fortnight::with('quarter.year')->paginate(30);
        $currentFortnight = Fortnight::currentFortnight();
        return view('fortnights.index', compact('fortnights', 'currentFortnight'));
    }

    // Show the form for creating a new fortnight
    public function create()
    {
        $quarters = Quarter::with('year')->get();

        if (count($quarters) == 0) {
            return redirect()->route('fortnights.index')->with('status', 'parent');
        } else {

            return view('fortnights.create', compact('quarters'));
        }

    }

    // Store a newly created fortnight in the database
    public function store(Request $request)
    {
        $request->validate([
            'quarter_id' => 'required|exists:quarters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Fortnight::create($request->all());

        return redirect()->route('fortnights.index')->with('status', 'Fortnight has been successfully Created.');
    }

    // Display the specified fortnight
    public function show(Fortnight $fortnight, Request $request)
    {
        $fortnight->load('tasks', 'deliverables');

        if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN'])) {
            $tasks = Task::with(['target', 'departments'])->whereHas('fortnights', function ($query) use ($fortnight) {
                $query->where('fortnights.id', $fortnight->id);
            });

            $deliverables = $fortnight->deliverables()->paginate(30);

        } elseif (request()->user()->hasAnyRole(['DEPARTMENT_HEAD'])) {
            $headOf = request()->user()->load('headOf')->headOf;

            $tasks = $headOf ? $headOf->tasks()->whereHas('fortnights', function ($query) use ($fortnight) {
                $query->where('fortnights.id', $fortnight->id);
            }) : Task::query();
            
            $deliverables = $fortnight->deliverables()->whereHas('user', function ($query) use ($headOf) {
                $query->where('department_id', $headOf->id);
            })->paginate(30);
        } elseif (request()->user()->hasRole('EMPLOYEE')) {
            $tasks = request()->user()->tasks()->with(['target', 'departments'])->whereHas('fortnights', function ($query) use ($fortnight) {
                $query->where('fortnights.id', $fortnight->id);
            });

            $deliverables = $fortnight->deliverables()->where('user_id', request()->user()->id)->paginate(30);

        }

        // Check tasks index and also the Service to understand how this functions work
        $filterTasksService = new FilterTasksService;

        [$tasks] = $filterTasksService->filterByScope($tasks, $request);
        $tasks = $filterTasksService->filterByColumns($tasks, $request);
        $tasks = $tasks->paginate(30);

        return view('fortnights.show', compact('fortnight', 'deliverables', 'tasks'));
    }

    public function printableReport(Request $request, Fortnight $fortnight)
    {
        // $fortnightStartDate = Fortnight::currentFortnight()->start_date;
        $fortnight = $fortnight ? $fortnight : Fortnight::currentFortnight();
        $fortnightId = $fortnight->id;
        $users = User::orderBy('name', 'asc')->withCount([
            'tasks as all_tasks' => function ($query) use ($fortnightId) {
                $query->whereHas('fortnights', function ($q) use ($fortnightId) {
                    $q->where('fortnights.id', $fortnightId);
                });
            },

            'tasks as pending_tasks' => function ($query) use ($fortnightId) {
                $query->where('status', 'pending')
                    ->whereHas('fortnights', function ($q) use ($fortnightId) {
                        $q->where('fortnights.id', $fortnightId);
                    });
            },
            'tasks as progress_tasks' => function ($query) use ($fortnightId) {
                $query->where('status', 'progress')
                    ->whereHas('fortnights', function ($q) use ($fortnightId) {
                        $q->where('fortnights.id', $fortnightId);
                    });
            },
            'tasks as completed_tasks' => function ($query) use ($fortnightId) {
                $query->where('status', 'completed')
                    ->whereHas('fortnights', function ($q) use ($fortnightId) {
                        $q->where('fortnights.id', $fortnightId);
                    });
            },

        ])->get();

        $deliverables = $fortnight->deliverables()->with('user')->get();

        // Load the Blade view into DomPDF
        $pdf = PDF::loadView('fortnights.printableReport', [
            'users' => $users,
            'fortnight' => $fortnight,
            'deliverables' => $deliverables,
        ]);

        $fileName = 'Fortnight_Tasks_Report_' . $fortnight->start_date . '_' . $fortnight->end_date . '.pdf';

        // Download the file
        return $pdf->download($fileName);
        
    }

    // Show the form for editing the specified fortnight
    public function edit(Fortnight $fortnight)
    {
        $quarters = Quarter::with('year')->get();

        return view('fortnights.edit', compact('fortnight', 'quarters'));
    }

    // Update the specified fortnight in the database
    public function update(Request $request, Fortnight $fortnight)
    {
        $request->validate([
            'quarter_id' => 'required|exists:quarters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $fortnight->update($request->all());

        return redirect()->route('fortnights.index')->with('status', 'Fortnight has been successfully Updated.');
    }

    // Remove the specified fortnight from the database
    public function destroy(Fortnight $fortnight)
    {
        if ($fortnight->tasks()->exists() || $fortnight->days()->exists()) {
            return redirect()->route('fortnights.index')
                ->with('related', 'Item-related');
        } else {
            $fortnight->delete();

            return redirect()->route('fortnights.index')->with('status', 'Fortnight has been successfully Deleted.');
        }
    }
}
