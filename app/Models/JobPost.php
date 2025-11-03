<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'questions_id',
        'question_options_id',
        'location',
        'message',
        'image',
        'start_date',
        'end_date',
    ];

    // JSON FIELD CAST
    protected $casts = [
        'questions_id' => 'array',
        'question_options_id' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /** Relation with User */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relation with Category */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /** Relation with review */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
