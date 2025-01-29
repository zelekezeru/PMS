@extends('layouts.app')

@section('contents')

    <div class="container mt-5 pt-5">
        <!-- Strategie Details Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title col-8">Pillar Details</h3>
                <div class="d-flex col-2">
                    <a href="{{ route('strategies.index') }}" class="btn btn-primary btn-sm float-end mr-2">Back to Pillars</a>
                </div>
            </div>
            <div class="card-body">
                <!-- Strategie Title -->
                <h3 class="mb-3"><i class="fas fa-book"></i><strong class=" m-2 h2 text-info">Pilar:</strong>  {{ $strategy->pilar_name }}</h3>

                <!-- Strategy Details -->
                <div class="row">
                    <div class="col mt-5">
                        <p><strong class="h3 text-info">Strategy:</strong> {{ $strategy->name }}</p>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-12">
                        <p><strong class="h3 text-info">Description:</strong> {{ $strategy->description }}</p>
                    </div>

                </div>

                <!-- Edit and Delete buttons -->
                <div class="mt-4">
                    <a href="{{ route('strategies.edit', $strategy->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit Pillar & Strategy
                    </a>

                    <form action="{{ route('strategies.destroy', $strategy->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategie?')">
                            <i class="fas fa-trash"></i> Delete Edit Pillar & Strategy
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if ($strategy->goals)

            @php
                $goals = $strategy->goals;
            @endphp

            @include('goals.list')

        @else
            <div class="alert alert-warning mt-3">
                <p>No goals found for this strategy.</p>
            </div>
        @endif

    </div>

@endsection
