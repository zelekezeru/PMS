<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function kpi()
    {
        return $this->hasOne(Kpi::class);
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
}
