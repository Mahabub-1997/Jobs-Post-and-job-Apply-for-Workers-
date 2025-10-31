<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Category
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'image',
    ];

    /**
     * Get the full URL for the category image.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /**
     * Scope a query to search categories by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByName($query, ?string $term)
    {
        if ($term) {
            $query->where('name', 'LIKE', "%{$term}%");
        }
        return $query;
    }

    // Relationship to Questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    // Relationship to JobPost
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }


}
