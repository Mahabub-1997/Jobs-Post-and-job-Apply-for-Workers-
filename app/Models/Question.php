<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'questions'];

    // Cast the JSON column to array automatically
    protected $casts = [
        'questions' => 'array',
    ];

    /**
     * A Question belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A Question has many Options
     */
    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

}
