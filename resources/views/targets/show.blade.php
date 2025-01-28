@extends('layouts.app')

@section('contents')

    <div class="container mt-5 pt-5">
        <!-- Strategie Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">target Details</h3>
                <a href="{{ route('targets.index') }}" class="btn btn-primary btn-sm float-end">Back to targets</a>
            </div>
            <div class="card-body">
                <!-- Strategie Title -->
                <h3 class="mb-3"><i class="fas fa-book"></i><strong class=" m-2 h2">Pilar Name:</strong>  {{ $target->pilar_name }}</h3>

                <!-- target Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h3">Name:</strong> {{ $target->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h3">Description:</strong> {{ $target->description }}</p>
                    </div>
                </div>

                <!-- Edit and Delete buttons -->
                <div class="mt-4">
                    <a href="{{ route('targets.edit', $target->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit target
                    </a>

                    <form action="{{ route('targets.destroy', $target->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategie?')">
                            <i class="fas fa-trash"></i> Delete target
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection