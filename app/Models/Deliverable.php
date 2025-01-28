<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deliverable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function fortnight()
    {
        return $this->belongsTo(Fortnight::class);
    }
}
