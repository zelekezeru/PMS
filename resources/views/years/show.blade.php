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
                </table>

            </div>
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
