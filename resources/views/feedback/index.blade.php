@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Feedback List</h1>
    <a href="{{ route('feedback.create') }}" class="btn btn-primary mb-3">Add Feedback</a>
    @include('feedback.list')
</div>
@endsection