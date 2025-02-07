@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Feedback</h1>
    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf
        @include('feedback._form')
    </form>
</div>
@endsection