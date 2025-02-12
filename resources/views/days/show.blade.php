@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Day Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('days.index') }}">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Year:</th>
                        <td>{{ $day->fortnight->quarter->year->year }}</td>
                    </tr>
                    <tr>
                        <th>Quarter:</th>
                        <td>{{ $day->fortnight->quarter->quarter }}</td>
                    </tr>
                    <tr>
                        <th>Fortnight:</th>
                        <td>{{ $day->fortnight->start_date }} to {{ $day->fortnight->end_date }}</td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ $day->date }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $day->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At:</th>
                        <td>{{ $day->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>

                @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('days.edit', $day->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('days.destroy', $day->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this day?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

@endsection