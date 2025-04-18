<?php

namespace App\Http\Controllers;

use App\Http\Requests\TargetStoreRequest;
use App\Http\Requests\TargetUpdateRequest;
use App\Models\Department;
use App\Models\Goal;
use App\Models\Kpi;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function index(Request $request)
    {
        $query = Target::with(['goal', 'departments']);

        if ($request->has('goal_id') && ! empty($request->goal_id)) {
            $query->where('goal_id', $request->goal_id);
        }

        $targets = $query->paginate(15);

        $goals = Goal::with(['targets'])->get();

        return view('targets.index', compact('targets', 'goals'));
    }

    public function create()
    {
        $goals = Goal::get();

        $departments = Department::get();

        return view('targets.create', compact('goals', 'departments'));
    }

    public function store(TargetStoreRequest $request)
    {
        $goal = Goal::where('id', $request->goal_id)->get();

        $departments = $request->department_id;

        unset($request['department_id']);

        $target = Target::create($request->validated());

        $target->departments()->attach($departments);

        return redirect()->route('targets.index')->with('status', 'Target has been successfully Created.');
    }

    public function show(Target $target)
    {
        $target->load('kpi');

        return view('targets.show', compact('target'));
    }

    public function edit(Target $target)
    {
        $goals = Goal::get();

        $kpis = Kpi::get();

        $departments = Department::get();

        return view('targets.edit', compact('target', 'goals', 'kpis', 'departments'));
    }

    public function update(TargetUpdateRequest $request, Target $target)
    {
        $target->update($request->validated());

        $departments = $request->department_id;

        if ($departments) {
            $target->departments()->sync($departments);
        }

        return redirect()->route('targets.index')->with('status', 'Target has been successfully Updated.');
    }

    public function destroy(Target $target)
    {
        if ($target->tasks()->exists() || $target->departments()->exists() || $target->year()->exists() || $target->kpi()->exists()) {
            return redirect()->route('targets.index')
                ->with('related', 'target-deleted');
        }
        $target->delete();

        return redirect()->route('targets.index')->with('status', 'Target has been successfully Deleted.');
    }
}
