<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
    ];

    // Relation: A subscription belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation: A subscription can have many trade applications
    public function tradeApplications()
    {
        return $this->hasMany(TradeApplication::class);
    }
}
