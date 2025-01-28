@extends('layouts.app')

@section('contents')

    <div class="container mt-5 pt-5">
        <!-- Strategie Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">kpi Details</h3>
                <a href="{{ route('kpis.index') }}" class="btn btn-primary btn-sm float-end">Back to kpis</a>
            </div>
            <div class="card-body">
                <!-- Strategie Title -->
                <h3 class="mb-3"><i class="fas fa-book"></i><strong class=" m-2 h2">Pilar Name:</strong>  {{ $kpi->pilar_name }}</h3>

                <!-- kpi Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h3">Name:</strong> {{ $kpi->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h3">Description:</strong> {{ $kpi->description }}</p>
                    </div>
                </div>

                <!-- Edit and Delete buttons -->
                <div class="mt-4">
                    <a href="{{ route('kpis.edit', $kpi->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit kpi
                    </a>

                    <form action="{{ route('kpis.destroy', $kpi->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategie?')">
                            <i class="fas fa-trash"></i> Delete kpi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection