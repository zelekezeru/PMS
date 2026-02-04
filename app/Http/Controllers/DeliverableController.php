<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliverableStoreRequest;
use App\Http\Requests\DeliverableUpdateRequest;
use App\Models\Deliverable;
use App\Models\Fortnight;

class DeliverableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fortnightId = request()->query('fortnight');

        // If the index is filtered by fortnight, load that fortnight so the modal can use its dates
        $fortnight = $fortnightId ? Fortnight::find($fortnightId) : null;

        // Get deliverables for the given fortnight, or all if not filtered
        $deliverables = $fortnight->deliverables()->paginate(30) ?? Deliverable::paginate(30);
        
        return view('deliverables.index', compact('deliverables', 'fortnightId', 'fortnight'));
    }
    /**
     * Show the RESOURSE.
     */
    public function show(Deliverable $deliverable)
    {
        $fortnight = $deliverable->fortnight;

        return view('deliverables.show', compact('deliverable', 'fortnight'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliverableStoreRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = request()->user()->id;

        $deliverable = Deliverable::create($data);

        // Load relations needed for the partial
        $deliverable->load('user');

        // If AJAX/JSON request, return rendered row and success message so client can update in-place
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Deliverable has been successfully created.',
                'html' => view('deliverables._row', compact('deliverable'))->render(),
                'deliverable' => $deliverable,
            ], 201);
        }

        if ($request->filled('fortnight_id')) {
            return redirect()->route('fortnights.show', $request->fortnight_id)->with('status', 'Deliverable has been successfully created.');
        }

        return redirect()->route('deliverables.index')->with('status', 'Deliverable has been successfully created.');

    }

    /**
     * Display the specified resource.
     */
    public function achieved(Deliverable $deliverable)
    {
        $deliverable->is_completed = 1;

        $deliverable->save();
        
        return redirect()->back()->with('status', 'Deliverable has been successfully Achieved.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deliverable $deliverable)
    {
        $fortnight = $deliverable->fortnight;

        return view('deliverables.edit', compact('deliverable', 'fortnight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliverableUpdateRequest $request, Deliverable $deliverable)
    {
        $data = $request->validated();
        
        $deliverable->update($data);

        return redirect()->route('deliverables.show', $deliverable->id)->with('status', 'Deliverable has been successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deliverable $deliverable)
    {
        $fortnightId = $deliverable->fortnight->id;

        $deliverable->delete();

        return redirect()->route('fortnights.show', $fortnightId)->with('status', 'Deliverable deleted successfully.');
    }
}
