<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quarter extends Model
{
    use HasFactory;

    protected $fillable = ['year_id', 'quarter'];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function fortnights()
    {
        return $this->hasMany(Fortnight::class);
    }
}
