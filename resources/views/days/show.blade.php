@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Day Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('days.index') }}">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <h5><strong>Year:</strong></h5>
                <p>{{ $day->fortnight->quarter->year->year }}</p>

                <h5><strong>Quarter:</strong></h5>
                <p>{{ $day->fortnight->quarter->quarter }}</p>

                <h5><strong>Fortnight:</strong></h5>
                <p>{{ $day->fortnight->start_date }} to {{ $day->fortnight->end_date }}</p>

                <h5><strong>Date:</strong></h5>
                <p>{{ $day->date }}</p>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('days.edit', $day->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('days.destroy', $day->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
