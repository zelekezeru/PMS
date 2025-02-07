<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::with(['task', 'user', 'parentFeedback', 'replies'])->get();
        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tasks = Task::all();
        $users = User::all();
        $parentFeedbacks = Feedback::all();
        return view('feedback.create', compact('tasks', 'users', 'parentFeedbacks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'feedback_id' => 'nullable|exists:feedback,id',
            'comment' => 'required|string',
        ]);

        Feedback::create($request->all());

        return redirect()->route('feedback.index')->with('success', 'Feedback created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        $tasks = Task::all();
        $users = User::all();
        $parentFeedbacks = Feedback::all();
        return view('feedback.edit', compact('feedback', 'tasks', 'users', 'parentFeedbacks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'feedback_id' => 'nullable|exists:feedback,id',
            'comment' => 'required|string',
        ]);

        $feedback->update($request->all());

        return redirect()->route('feedback.index')->with('success', 'Feedback updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback deleted successfully.');
    }
}