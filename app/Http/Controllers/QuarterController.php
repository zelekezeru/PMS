<?php

namespace App\Http\Controllers;

use App\Models\Quarter;
use App\Models\Year;
use Illuminate\Http\Request;

class QuarterController extends Controller
{
    public function index()
    {
        $quarters = Quarter::with('year')->get();
        return view('quarters.index', compact('quarters'));
    }

    public function create()
    {
        $years = Year::all();
        return view('quarters.create', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'quarter' => 'required|in:Q1,Q2,Q3,Q4',
        ]);

        Quarter::create($request->all());

        return redirect()->route('quarters.index')->with('success', 'Quarter added successfully.');
    }

    // Display the specified quarter
    public function show(Quarter $quarter)
    {
        return view('quarters.show', compact('quarter'));
    }

    public function edit(Quarter $quarter)
    {
        $years = Year::all();
        return view('quarters.edit', compact('quarter', 'years'));
    }

    public function update(Request $request, Quarter $quarter)
    {
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'quarter' => 'required|in:Q1,Q2,Q3,Q4',
        ]);

        $quarter->update($request->all());

        return redirect()->route('quarters.index')->with('success', 'Quarter updated successfully.');
    }

    public function destroy(Quarter $quarter)
    {
        $quarter->delete();
        return redirect()->route('quarters.index')->with('success', 'Quarter deleted successfully.');
    }
}
