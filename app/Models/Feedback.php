<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'feedback_id',
        'comment'
    ];

    // Relationship: A feedback belongs to a task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relationship: A feedback belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A feedback can have replies
    public function replies()
    {
        return $this->hasMany(Feedback::class, 'feedback_id');
    }

    // Relationship: A feedback may have a parent feedback
    public function parent()
    {
        return $this->belongsTo(Feedback::class, 'feedback_id');
    }
}
