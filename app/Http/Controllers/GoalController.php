<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GoalStoreRequest;
use App\Http\Requests\GoalUpdateRequest;
use App\Models\Strategy;
use Illuminate\View\View;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::with('strategy')->paginate(10);
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        $strategies = Strategy::all();

        return view('goals.create', compact('strategies'));
    }

    public function store(GoalStoreRequest $request)
    {
        Goal::create($request->validated());

        return redirect()->route('goals.index')->with('success', 'Goal created successfully.');
    }

    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    public function edit(Goal $goal)
    {
        $strategies = Strategy::all();
        return view('goals.edit', compact('goal', 'strategies'));
    }

    public function update(GoalUpdateRequest $request, Goal $goal)
    {
        $data = $request->validated();
        
        $goal->update($data);

        return redirect()->route('goals.index')->with('success', 'Goal updated successfully.');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully.');
    }
}
