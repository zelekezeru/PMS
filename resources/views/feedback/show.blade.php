@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Feedback Details</h1>
    <p><strong>Task:</strong> {{ $feedback->task->name }}</p>
    <p><strong>User:</strong> {{ $feedback->user->name }}</p>
    <p><strong>Comment:</strong> {{ $feedback->comment }}</p>
    <p><strong>Parent Feedback:</strong> {{ $feedback->parentFeedback ? $feedback->parentFeedback->comment : 'N/A' }}</p>
    <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection