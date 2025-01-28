@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Targets List</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('targets.create') }}"><i class="fa fa-plus"></i> Add New Target</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Budget</th>
                            <th>Department</th>
                            <th>Value</th>
                            <th>Unit</th>
                            <th>Goal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($targets as $target)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $target->name }}</td>
                                <td>{{ $target->budget }}</td>
                                <td>{{ $target->department }}</td>
                                <td>{{ $target->value }}</td>
                                <td>{{ $target->unit }}</td>
                                <td>{{ $target->goal->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('targets.edit', $target->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ route('targets.show', $target->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-book"></i> Show</a>
                                    <form action="{{ route('targets.destroy', $target->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="m-1 btn  btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this target?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No targets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $targets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
