<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strategy extends Model
{
    use HasFactory;

    protected $fillable = [
        'pilar_name',
        'name',
        'description',
    ];

    public function targets()
    {
        return $this->hasMany(Target::class);
    }
}
