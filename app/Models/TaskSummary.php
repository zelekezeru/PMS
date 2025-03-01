<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'user_id',
        'user_name',
        'department_id',
        'department_name',
        'all_tasks',
        'pending_kpis',
        'progress_kpis',
        'completed_kpis',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
