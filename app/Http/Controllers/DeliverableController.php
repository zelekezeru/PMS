<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliverableStoreRequest;
use App\Http\Requests\DeliverableUpdateRequest;
use App\Models\Deliverable;
use Illuminate\Http\Request;

class DeliverableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        return redirect()->route('fortnights.show', $request->fortnight_id)->with('status', 'Deliverable has been successfully created.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Deliverable $deliverable)
    {
        //
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

        return redirect()->route('fortnights.show', $deliverable->fortnight->id)->with('status', 'Deliverable has been successfully created.');
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
