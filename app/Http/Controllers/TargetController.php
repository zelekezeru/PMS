<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TargetStoreRequest;
use App\Http\Requests\TargetUpdateRequest;
use App\Models\Goal;
use App\Models\Kpi;
use Illuminate\View\View;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::with(['goal'])->paginate(10);

        return view('targets.index', compact('targets'));
    }

    public function create()
    {
        $goals = Goal::all();

        return view('targets.create', compact('goals'));
    }

    public function store(TargetStoreRequest $request)
    {
        $goal = Goal::where('id', $request->goal_id)->get();

        Target::create($request->validated());

        return redirect()->route('targets.index')->with('success', 'Target created successfully.');
    }

    public function show(Target $target)
    {
        return view('targets.show', compact('target'));
    }

    public function edit(Target $target)
    {
        $goals = Goal::all();

        $kpis = Kpi::all();

        return view('targets.edit', compact('target', 'goals', 'kpis'));
    }

    public function update(TargetUpdateRequest $request, Target $target)
    {
        $target->update($request->validated());

        return redirect()->route('targets.index')->with('success', 'Target updated successfully.');
    }

    public function destroy(Target $target)
    {
        $target->delete();

        return redirect()->route('targets.index')->with('success', 'Target deleted successfully.');
    }
}
