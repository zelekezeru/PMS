<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DailyTask extends Model
{
    protected $guarded = [];

    /**
     * Cast the `date` attribute to a Carbon instance
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * The user assigned to this daily task
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
