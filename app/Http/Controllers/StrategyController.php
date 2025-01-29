<?php

namespace App\Http\Controllers;

use App\Models\Strategy;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StrategyStoreRequest;
use App\Http\Requests\StrategyUpdateRequest;
use Illuminate\View\View;

class StrategyController extends Controller
{
    /**
     * Display a indexing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(StrategyStoreRequest $request) : RedirectResponse
    {
        Strategy::create($request->validated());

        // Redirect to the create page with a success message
        return redirect()->route('strategies.index')
            ->with('success', 'strategies created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Strategy $strategy) : View
    {
        return view('strategies.show', compact('strategy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Strategy $strategy) : View
    {
        return view('strategies.edit', compact('strategy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StrategyUpdateRequest $request, Strategy $strategy): RedirectResponse
    {
        $data = $request->validated();

        $strategy->update($data);

        return redirect()->route('strategies.index')
            ->with('success', 'strategies updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Strategy $strategy)
    {
        $strategy->delete();

        return redirect()->route('strategies.index')
            ->with('success', 'strategies deleted successfully');
    }
}
