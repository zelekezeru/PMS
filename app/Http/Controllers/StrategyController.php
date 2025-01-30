<?php

namespace App\Http\Controllers;

use App\Models\Strategy;
use Illuminate\Http\Request;
use App\Http\Requests\StrategyStoreRequest;
use App\Http\Requests\StrategyUpdateRequest;
use Illuminate\View\View;

class StrategyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $strategies = Strategy::paginate(10); // Use pagination to avoid loading too many records at once

        return view('strategies.index', compact('strategies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $strategy = new Strategy;

        return view('strategies.create', compact('strategy'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Strategy $strategy): View
    {
        return view('strategies.show', compact('strategy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Strategy $strategy): View
    {
        return view('strategies.edit', compact('strategy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pilar_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $strategy = new Strategy($request->all());
        $strategy->save();

        return redirect()->route('strategies.index')->with('status', 'strategy-created');
    }

    public function update(Request $request, Strategy $strategy)
    {
        $request->validate([
            'pilar_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $strategy->update($request->all());

        return redirect()->route('strategies.index')->with('status', 'strategy-updated');
    }

    public function destroy(Strategy $strategy)
    {
        $strategy->delete();

        return redirect()->route('strategies.index')
            ->with('status', 'strategy-deleted');
    }

}
