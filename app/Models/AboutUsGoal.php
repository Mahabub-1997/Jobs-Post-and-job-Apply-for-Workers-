<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsGoal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'goals',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'goals' => 'array', // Automatically casts JSON to array
    ];

    /**
     * Ensure goals always returns an array, even if null.
     *
     * @return array
     */
    public function getGoalsAttribute($value): array
    {
        return $value ?? [];
    }
}
