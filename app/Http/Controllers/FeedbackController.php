<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Fetch feedback for a task
    public function index($taskId)
    {
        $feedback = Feedback::where('task_id', $taskId)
            ->with('user', 'replies.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($feedback);
    }

    public function taskFeedbacks($taskId)
    {
        $feedback = Feedback::where('task_id', $taskId)
            ->with('user', 'replies.user', 'parent')
            ->where('feedback_id', null)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($feedback);
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required|string',
            'feedback_id' => 'nullable|exists:feedback,id',
        ]);

        $feedback = Feedback::create([
            'task_id' => $request->task_id,
            'user_id' => Auth::id(),
            'feedback_id' => $request->feedback_id,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'id' => $feedback->id,
            'comment' => $feedback->comment,
            'user' => ['name' => Auth::user()->name],
            'feedback_id' => $feedback->feedback_id,
            'created_at' => $feedback->created_at,
            'replies' => [],
        ], 201);
    }

    public function destroy($id)
    {
        // Find the feedback by its ID
        $feedback = Feedback::find($id);

        // Check if the feedback exists
        if (! $feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        // Check if the logged-in user is the owner of the feedback
        if ($feedback->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete any replies associated with this feedback
        $feedback->replies()->delete();

        // Delete the feedback itself
        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted successfully'], 200);
    }
}
