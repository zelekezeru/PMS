<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
