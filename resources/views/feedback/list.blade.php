<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Task</th>
            <th>User</th>
            <th>Comment</th>
            <th>Parent Feedback</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($feedbacks as $feedback)
        <tr>
            <td>{{ $feedback->id }}</td>
            <td>{{ $feedback->task->name }}</td>
            <td>{{ $feedback->user->name }}</td>
            <td>{{ $feedback->comment }}</td>
            <td>{{ $feedback->parentFeedback ? $feedback->parentFeedback->comment : 'N/A' }}</td>
            <td>
                <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-info">View</a>
                <a href="{{ route('feedback.edit', $feedback->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>