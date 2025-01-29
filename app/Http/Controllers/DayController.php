<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Fortnight;
use App\Models\Quarter;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function index()
    {
        $days = Day::all();
        return view('days.index', compact('days'));
    }

    public function create()
{
    
    $fortnights = Fortnight::with('quarter.year')->get();

    return view('days.create', compact('fortnights'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'fortnight_id' => 'required|exists:fortnights,id',
            'date' => 'required|date|unique:days,date',
        ]);

        Day::create($validated);

        return redirect()->route('days.index');

    }

    public function show(Day $day)
    {
        return view('days.show', compact('day'));
    }
    
    public function edit(Day $day)
    {
        
        $fortnights = Fortnight::with('quarter.year')->get();
    
        return view('days.edit', compact('day', 'fortnights'));
    }

    public function update(Request $request, Day $day)
    {
        $validated = $request->validate([
            'fortnight_id' => 'required|exists:fortnights,id',
            'date' => 'required|date|unique:days,date,' . $day->id,
        ]);

        $day->update($validated);

        return redirect()->route('days.index');
    }

    // Destroy method to delete the Day
    public function destroy(Day $day)
    {
        $day->delete();

        return redirect()->route('days.index');
    }
}
