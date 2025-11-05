<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Relation with jobPosts
     */
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
    /**
     * Relation with tradeApplications
     */
    public function tradeApplications()
    {
        return $this->hasMany(TradeApplication::class);
    }

    /**
     * Relation with categories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'trade_applications', 'user_id', 'category_id')
            ->withTimestamps();
    }
    /**
     * Relation with reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    /**
     * Relation with appliedJobs
     */
    public function appliedJobs()
    {
        return $this->belongsToMany(JobPost::class, 'job_applications', 'user_id', 'job_post_id')
            ->withTimestamps();
    }
}
