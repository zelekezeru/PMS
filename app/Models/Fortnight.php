<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fortnight extends Model
{
    use HasFactory;

    protected $fillable = [
        'quarter_id',
        'start_date',
        'end_date',
    ];

    public static function currentFortnight()
    {
        $today = now()->toDateString();
        $fortnight = self::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();

        if (!$fortnight) {
            // Optionally, you can throw an exception or handle as needed
            // abort(404); // Uncomment to abort with 404
            return null;
        }

        return $fortnight;
    }

    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    public function days()
    {
        return $this->hasMany(Day::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }
}
