<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Year extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quarters()
    {
        return $this->hasMany(Quarter::class);
    }

    public function targets()
    {
        return $this->hasMany(Target::class);
    }
}
