<?php

namespace App\Http\Controllers;

use App\Http\Requests\KpiStoreRequest;
use App\Http\Requests\KpiUpdateRequest;
use App\Models\Kpi;
use App\Models\Task;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KpiController extends Controller
{
    public function index()
    {
        $kpis = Kpi::with('task')->paginate(10);

        return view('kpis.index', compact('kpis'));
    }

    public function create($target)
    {
        $target = Target::findOrFail($target);

        return view('kpis.create', compact('target'));
    }

    public function create_task($task)
    {
        $task = Task::findOrFail($task);

        return view('kpis.create', compact('task'));
    }

    public function create_target($target)
    {
        $target = Target::findOrFail($target);

        return view('kpis.create', compact('target'));
    }

    public function store(KpiStoreRequest $request)
    {
        Kpi::create($request->validated());
        if ($request['task_id']) {
            return redirect()->route('tasks.show', $request['task_id'])->with('success', 'KPI created successfully.');
        } else if ($request['target_id']) {
            return redirect()->route('targets.show', $request['target_id'])->with('success', 'KPI created successfully.');
        }

        return redirect()->route('tasks.show', $request['task_id'])->with('success', 'KPI created successfully.');
    }

    public function show(Kpi $kpi)
    {
        return view('kpis.show', compact('kpi'));
    }

    public function edit(Kpi $kpi)
    {
        if($kpi->task_id != null)
        {
            $task = Task::where('id', $kpi->task_id)->first();

            $target = null;
        }
        elseif($kpi->target_id != null)
        {
            $target = Target::where('id', $kpi->target_id)->first();

            $task = null;
        }

        return view('kpis.edit', compact('kpi', 'task', 'target'));
    }

    public function update(KpiUpdateRequest $request, Kpi $kpi)
    {
        $kpi->update($request->validated());

        if ($request['task_id']) {
            return redirect()->route('tasks.show', $request['task_id'])->with('success', 'KPI created successfully.');
        } else if ($request['target_id']) {
            return redirect()->route('targets.show', $request['target_id'])->with('success', 'KPI created successfully.');
        }
        return redirect()->route('tasks.show', $request['task_id'])->with('success', 'KPI created successfully.');
    }

    public function destroy(Kpi $kpi)
    {
        $task_kpi = $kpi->task_id;

        $kpi->delete();

        if ($kpi->task_id != null) {
            return redirect()->route('tasks.show', $task_kpi)->with('success', 'KPI created successfully.');
        } else if ($kpi->target_id != null) {
            return redirect()->route('targets.show', $task_kpi)->with('success', 'KPI created successfully.');
        }

        return redirect()->route('tasks.show', $task_kpi)->with('success', 'KPI created successfully.');
    }

    /**
     * Approve the specified KPI.
     */
    public function approve($id)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->approved_by = Auth::user()->id;
        $kpi->save();

        if ($kpi->task_id != null) {
            return redirect()->route('tasks.show', $kpi->task_id)->with('success', 'KPI Approved successfully.');
        } else if ($kpi->target_id != null) {
            return redirect()->route('targets.show', $kpi->target_id)->with('success', 'KPI Approved successfully.');
        }
    }

    /**
     * Confirm the specified KPI.
     */
    public function confirm($id)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->confirmed_by = Auth::user()->id;
        $kpi->save();


        if ($kpi->task_id != null) {
            return redirect()->route('tasks.show', $kpi->task_id)->with('success', 'KPI Confirmed successfully.');
        } else if ($kpi->target_id != null) {
            return redirect()->route('targets.show', $kpi->target_id)->with('success', 'KPI Confirmed successfully.');
        }
    }

    public function updateStatus(Request $request, Kpi $kpi)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $kpi->status = $request->status;
        $kpi->save();

        if ($kpi->task_id != null) {
            return redirect()->route('tasks.show', $kpi->task_id)->with('success', 'KPI Confirmed successfully.');
        } else if ($kpi->target_id != null) {
            return redirect()->route('targets.show', $kpi->target_id)->with('success', 'KPI Confirmed successfully.');
        }
    }
}
