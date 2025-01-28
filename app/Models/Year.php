<?php

namespace App\Models;

use Carbon\Month;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Year extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function months()
    {
        return $this->hasMany(Month::class);
    }
}
