<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    use HasFactory;

    protected $table = 'job_applications'; //

    protected $fillable = ['job_post_id', 'user_id'];

    public function jobPost()
    {
        return $this->belongsTo(\App\Models\JobPost::class, 'job_post_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
