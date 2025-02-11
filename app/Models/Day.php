<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Day extends Model
{
    use HasFactory;

    protected $fillable = ['fortnight_id', 'date'];

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function fortnight()
    {
        return $this->belongsTo(Fortnight::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
