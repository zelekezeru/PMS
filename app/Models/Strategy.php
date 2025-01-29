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

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }
}
