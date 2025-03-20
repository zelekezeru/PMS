<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fortnight extends Model
{
    use HasFactory;

    protected $fillable = [
        'quarter_id',
        'start_date',
        'end_date',
    ];

    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    public function days()
    {
        return $this->hasMany(Day::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }
}
