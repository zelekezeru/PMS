<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function users()
    {

        return $this->hasMany(User::class);
    }

    public function targets()
    {
        return $this->belongsToMany(Target::class);
    }

    public function departmentHead()
    {
        return $this->belongsTo(User::class, 'department_head');
    }
}
