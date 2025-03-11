<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskKpiSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'task_kpis',
        'pending_kpis',
        'progress_kpis',
        'completed_kpis',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
