<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strategy extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function targets()
    {
        return $this->hasMany(Target::class);
    }
}
