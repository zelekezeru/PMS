@extends('layouts.app')

@section('contents')

    <div class="container mt-5 pt-5">
        <!-- Strategie Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Goal Details</h3>
                <a href="{{ route('goals.index') }}" class="btn btn-primary btn-sm float-end"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                <!-- Strategie Title -->
                <h3 class="mb-3"><i class="fas fa-book"></i><strong class=" m-2 h2">Pilar Name:</strong>  {{ $goal->pilar_name }}</h3>

                <!-- goal Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h3">Name:</strong> {{ $goal->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h3">Description:</strong> {{ $goal->description }}</p>
                    </div>
                </div>

                <!-- Edit and Delete buttons -->
                <div class="mt-4">
                    <a href="{{ route('goals.edit', $goal->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit goal
                    </a>

                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategie?')">
                            <i class="fas fa-trash"></i> Delete goal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if ($goal->targets)

            @php
                $targets = $goal->targets;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Targets of this Goal</h3>
            </div>

            @include('targets.list')
        @else
            <div class="alert alert-warning mt-5">
                No targets found.
            </div>
        @endif
    </div>

@endsection
