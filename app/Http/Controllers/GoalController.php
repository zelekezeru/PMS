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
    public function index(Request $request)
    {
        $query = Goal::with('strategy');

        // Filtering by strategy
        if ($request->filled('strategy_id')) {
            $query->where('strategy_id', $request->strategy_id);
        }

        // Sorting by name (asc/desc)
        if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('name', $request->sort);
        } else {
            $query->orderBy('name', 'asc'); // Default sorting
        }

        $goals = $query->paginate(10);

        $strategies = Strategy::get(); // Fetch all strategies for the dropdown

        return view('goals.index', compact('goals', 'strategies'));
    }

    public function create()
    {
        $strategies = Strategy::get();

        return view('goals.create', compact('strategies'));
    }

    public function store(GoalStoreRequest $request)
    {
        Goal::create($request->validated());

        return redirect()->route('goals.index')->with('status', 'goal-created');
    }

    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    public function edit(Goal $goal)
    {
        $strategies = Strategy::get();

        return view('goals.edit', compact('goal', 'strategies'));
    }

    public function update(GoalUpdateRequest $request, Goal $goal)
    {
        $data = $request->validated();

        $goal->update($data);

        return redirect()->route('goals.index')->with('status', 'goal-updated');
    }

    public function destroy(Goal $goal)
    {
        if(count($goal->targets) != 0)
        {
            return redirect()->route('goals.index')
            ->with('related', 'goal-deleted');
        }

        $goal->delete();

        return redirect()->route('strategies.index')
            ->with('status', 'goal-deleted');
    }
}
