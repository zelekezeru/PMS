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
        $years = Year::get();

        if(count($years) == 0)
        {
            return redirect()->route('quarters.index')->with('status', 'parent');
        }
        else{

            return view('quarters.create', compact('years'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'quarter' => 'required|in:Q1,Q2,Q3,Q4',
        ]);

        Quarter::create($request->all());

        return redirect()->route('quarters.index')->with('status', 'Quarter has been successfully Created.');
    }

    public function show(Quarter $quarter)
    {
        return view('quarters.show', compact('quarter'));
    }

    public function edit(Quarter $quarter)
    {
        $years = Year::get();
        return view('quarters.edit', compact('quarter', 'years'));
    }

    public function update(Request $request, Quarter $quarter)
    {
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'quarter' => 'required|in:Q1,Q2,Q3,Q4',
        ]);

        $quarter->update($request->all());

        return redirect()->route('quarters.index')->with('status', 'Quarter has been successfully Updated.');
    }

    public function destroy(Quarter $quarter)
    {
        if($quarter->fortnights()->exists())
        {
            return redirect()->route('quarters.index')
            ->with('related', 'Item-related');
        }
        else{
            $quarter->delete();

            return redirect()->route('quarters.index')->with('status', 'Quarter has been successfully Deleted.');
        }

    }
}
