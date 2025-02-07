<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Task;
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
    
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required|string',
            'feedback_id' => 'nullable|exists:feedback,id'
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
            'created_at' => $feedback->created_at,
            'replies' => []
        ], 201);
    }
    
    
    
    
}
