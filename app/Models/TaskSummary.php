<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'all_tasks',
        'pending_tasks',
        'progress_tasks',
        'completed_tasks',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
