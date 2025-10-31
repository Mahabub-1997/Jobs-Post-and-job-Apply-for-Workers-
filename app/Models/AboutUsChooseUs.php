<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsChooseUs extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'sub_items',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sub_items' => 'array',
    ];

    /**
     * Ensure sub_items always returns an array.
     *
     * @return array
     */
    public function getSubItemsAttribute($value): array
    {
        return $value ?? [];
    }
}
