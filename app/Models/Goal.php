<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }

    public function targets()
    {
        return $this->hasMany(Target::class);
    }
}
