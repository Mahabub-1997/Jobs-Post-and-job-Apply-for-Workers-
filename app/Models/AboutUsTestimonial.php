<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsTestimonial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'testimonials',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'testimonials' => 'array', // Automatically casts JSON to array
    ];

    /**
     * Ensure testimonials always returns an array, even if null.
     *
     * @return array
     */
    public function getTestimonialsAttribute($value): array
    {
        return $value ?? [];
    }
}
