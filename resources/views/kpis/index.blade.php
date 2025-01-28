@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">KPIs List</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('kpis.create') }}"><i class="fa fa-plus"></i> Add New KPI</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Unit</th>
                            <th>Task</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kpis as $kpi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kpi->name }}</td>
                                <td>{{ $kpi->value }}</td>
                                <td>{{ $kpi->unit }}</td>
                                <td>{{ $kpi->task->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kpis.edit', $kpi->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ route('kpis.show', $kpi->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-book"></i> Show</a>
                                    <form action="{{ route('kpis.destroy', $kpi->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="m-1 btn  btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this KPI?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No KPIs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $kpis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
