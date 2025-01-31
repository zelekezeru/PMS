<?php

namespace App\Http\Controllers;

use App\Http\Requests\KpiStoreRequest;
use App\Http\Requests\KpiUpdateRequest;
use App\Models\Kpi;
use App\Models\Task;
use App\Models\Target;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    public function index()
    {
        $kpis = Kpi::with('task')->paginate(10);
        return view('kpis.index', compact('kpis'));
    }

    public function create($target)
    {
        dd($target);
        $target = Target::findOrFail($target);

        return view('kpis.create', compact('target'));
    }

    public function create_task($task)
    {
        dd($task);
        $task = Task::findOrFail($task);

        return view('kpis.create', compact('task'));
    }

    public function store(KpiStoreRequest $request)
    {
        Kpi::create($request->validated());
        return redirect()->route('kpis.index')->with('success', 'KPI created successfully.');
    }

    public function show(Kpi $kpi)
    {
        return view('kpis.show', compact('kpi'));
    }

    public function edit(Kpi $kpi)
    {
        $tasks = Task::get();
        return view('kpis.edit', compact('kpi', 'tasks'));
    }

    public function update(KpiUpdateRequest $request, Kpi $kpi)
    {
        $kpi->update($request->validated());
        return redirect()->route('kpis.index')->with('success', 'KPI updated successfully.');
    }

    public function destroy(Kpi $kpi)
    {
        $kpi->delete();
        return redirect()->route('kpis.index')->with('success', 'KPI deleted successfully.');
    }
}
