<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function kpi()
    {
        return $this->hasOne(Kpi::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
