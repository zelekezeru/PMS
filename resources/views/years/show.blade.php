@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Year Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('years.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Year:</th>
                        <td>{{ $year->year }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($year->active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('years.edit', $year->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $year->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $year->id }}" action="{{ route('years.destroy', $year->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endif
        
        </div>


        @if ($year->quarters)

            @php
                $quarters = $year->quarters;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Quarters of this year</h3>
            </div>

            @include('quarters.list')

        @else
            <div class="alert alert-warning mt-3">
                <p>No quarters found for this year.</p>
            </div>
        @endif
    </div>

@endsection
