@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Strategies List</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('strategies.create') }}"><i class="fa fa-plus"></i> Add New Strategy</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Pillar Name</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($strategies as $strategy)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $strategy->pilar_name }}</td>
                                <td>{{ $strategy->name }}</td>
                                <td>{{ $strategy->description }}</td>
                                <td class="text-center">
                                    <a href="{{ route('strategies.edit', $strategy->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ route('strategies.show', $strategy->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-book"></i> Show</a>
                                    <form action="{{ route('strategies.destroy', $strategy->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="m-1 btn  btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategy?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No strategies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
 
                <div class="mt-3">
                    {{ $strategies->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection