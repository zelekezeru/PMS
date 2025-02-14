<?php

namespace App\Http\Controllers;

use App\Models\Fortnight;
use App\Models\Quarter;
use Illuminate\Http\Request;

class FortnightController extends Controller
{
    // Display a listing of the fortnights
    public function index()
    {
        $fortnights = Fortnight::with('quarter.year')->paginate(15);
        return view('fortnights.index', compact('fortnights'));
    }

    // Show the form for creating a new fortnight
    public function create()
    {
        $quarters = Quarter::with('year')->get();

        if(count($quarters) == 0)
        {
            return redirect()->route('fortnights.index')->with('status', 'parent');
        }
        else{

            return view('fortnights.create', compact('quarters'));
        }

    }

    // Store a newly created fortnight in the database
    public function store(Request $request)
    {
        $request->validate([
            'quarter_id' => 'required|exists:quarters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Fortnight::create($request->all());

        return redirect()->route('fortnights.index')->with('status', 'Fortnight has been successfully Created.');
    }

    // Display the specified fortnight
    public function show(Fortnight $fortnight)
    {
        $fortnight->load('tasks');
        
        return view('fortnights.show', compact('fortnight'));
    }

    // Show the form for editing the specified fortnight
    public function edit(Fortnight $fortnight)
    {
        $quarters = Quarter::with('year')->get();
        return view('fortnights.edit', compact('fortnight', 'quarters'));
    }

    // Update the specified fortnight in the database
    public function update(Request $request, Fortnight $fortnight)
    {
        $request->validate([
            'quarter_id' => 'required|exists:quarters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $fortnight->update($request->all());

        return redirect()->route('fortnights.index')->with('status', 'Fortnight has been successfully Updated.');
    }

    // Remove the specified fortnight from the database
    public function destroy(Fortnight $fortnight)
    {
        if($fortnight->tasks()->exists() || $fortnight->days()->exists())
        {
            return redirect()->route('fortnights.index')
            ->with('related', 'Item-related');
        }
        else{
            $fortnight->delete();

            return redirect()->route('fortnights.index')->with('status', 'Fortnight has been successfully Deleted.');
        }
    }
}
