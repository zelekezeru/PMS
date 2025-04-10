<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function days()
    {
        return $this->belongsToMany(Day::class);
    }

    public function kpis()
    {
        return $this->hasMany(Kpi::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function fortnights()
    {
        return $this->belongsToMany(Fortnight::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function taskkpisummaries()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }
}
