<div class="form-group">
    <label for="task_id">Task</label>
    <select name="task_id" id="task_id" class="form-control" required>
        @foreach ($tasks as $task)
        <option value="{{ $task->id }}" {{ (isset($feedback) && $feedback->task_id == $task->id) ? 'selected' : '' }}>{{ $task->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="user_id">User</label>
    <select name="user_id" id="user_id" class="form-control" required>
        @foreach ($users as $user)
        <option value="{{ $user->id }}" {{ (isset($feedback) && $feedback->user_id == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="feedback_id">Parent Feedback (Optional)</label>
    <select name="feedback_id" id="feedback_id" class="form-control">
        <option value="">None</option>
        @foreach ($parentFeedbacks as $parentFeedback)
        <option value="{{ $parentFeedback->id }}" {{ (isset($feedback) && $feedback->feedback_id == $parentFeedback->id) ? 'selected' : '' }}>{{ $parentFeedback->comment }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="comment">Comment</label>
    <textarea name="comment" id="comment" class="form-control" required>{{ $feedback->comment ?? old('comment') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">{{ isset($feedback) ? 'Update' : 'Submit' }}</button>
<a href="{{ route('feedback.index') }}" class="btn btn-secondary">Cancel</a>