<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TargetStoreRequest;
use App\Http\Requests\TargetUpdateRequest;
use App\Models\Goal;
use App\Models\Target;
use App\Models\Kpi;
use App\Models\Department;
use Illuminate\View\View;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::with(['goal', 'departments'])->paginate(10);

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

        return redirect()->route('targets.index')->with('success', 'Target created successfully.');
    }

    public function show(Target $target)
    {

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

        return redirect()->route('targets.index')->with('success', 'Target updated successfully.');
    }

    public function destroy(Target $target)
    {
        if($target->tasks()->exists() || $target->departments()->exists() || $target->year()->exists() || $target->kpi()->exists())
        {
            return redirect()->route('targets.index')
            ->with('related', 'target-deleted');
        }
        $target->delete();

        return redirect()->route('targets.index')->with('success', 'Target deleted successfully.');
    }
}
