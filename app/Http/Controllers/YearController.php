<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index()
    {
        $years = Year::paginate(15);
        return view('years.index', compact('years'));
    }

    public function create()
    {
        return view('years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|unique:years,year'
        ]);

        Year::create($request->all());

        return redirect()->route('years.index')->with('status', 'Year has been successfully Created.');
    }

    public function show(Year $year)
    {
        return view('years.show', compact('year'));
    }

    public function edit(Year $year)
    {
        return view('years.edit', compact('year'));
    }

    public function update(Request $request, Year $year)
    {
        $request->validate([
            'year' => 'required|integer|unique:years,year,' . $year->id
        ]);

        $year->update($request->all());

        return redirect()->route('years.index')->with('status', 'Year has been successfully Updated.');
    }

    public function destroy(Year $year)
    {
        if($year->quarters()->exists())
        {
            return redirect()->route('years.index')
            ->with('related', 'Item-related');
        }

        $year->delete();

        return redirect()->route('years.index')->with('status', 'Year has been successfully Deleted.');
    }
}
