<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Week extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fortnight()
    {
        return $this->belongsTo(Fortnight::class);
    }

    public function days()
    {
        return $this->hasMany(Day::class);
    }
}
