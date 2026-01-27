<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    use HasFactory;

    protected $fillable = [
        'pillar_name',
        'name',
        'description',
        'year_id',
    ];

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }
}
