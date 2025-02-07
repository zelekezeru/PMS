@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Feedback</h1>
    <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('feedback._form')
    </form>
</div>
@endsection