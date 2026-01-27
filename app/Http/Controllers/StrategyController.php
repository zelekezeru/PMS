<?php

namespace App\Http\Controllers;

use App\Models\Strategy;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StrategyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $strategies = Strategy::paginate(30); // Use pagination to avoid loading too many records at once

        return view('strategies.index', compact('strategies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $strategy = new Strategy;

        $years = Year::get();

        return view('strategies.create', compact('strategy', 'years'));
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

        $years = Year::get();

        return view('strategies.edit', compact('strategy','years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pillar_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'year_id'=> 'required|exists:years,id',
        ]);

        $strategy = new Strategy($request->all());
        $strategy->save();

        return redirect()->route('strategies.index')->with('status', 'Strategy has been successfully created.');

    }

    public function update(Request $request, Strategy $strategy)
    {
        $request->validate([
            'pillar_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'year_id'=> 'sometimes|required|exists:years,id',
        ]);

        $strategy->update($request->all());

        return redirect()->route('strategies.index')->with('status', 'Strategy has been successfully updated.');

    }

    public function destroy(Strategy $strategy)
    {
        if ($strategy->goals()->exists()) {
            return redirect()->route('strategies.index')
                ->with('status', 'Strategy has been successfully deleted.');
        }

        $strategy->delete();

        return redirect()->route('strategies.index')->with('status', 'Strategy has been successfully deleted.');

    }
}
