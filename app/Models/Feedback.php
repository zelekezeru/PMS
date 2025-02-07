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
        'comment',
    ];

    // Define relationships
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentFeedback()
    {
        return $this->belongsTo(Feedback::class, 'feedback_id');
    }

    public function replies()
    {
        return $this->hasMany(Feedback::class, 'feedback_id');
    }
}