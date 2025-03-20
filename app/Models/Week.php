<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
