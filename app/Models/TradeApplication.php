<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'subscription_id',
        'first_name',
        'last_name',
        'company_name',
        'location',
        'phone',
        'email',
        'checkatrade_profile_link',
        'trustatrader_profile_link',
        'upload_trade_license',
        'upload_business_insurance',
        'passport_or_driving_license',
        'certificate',
        'status',
    ];

    // Relations to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relations to category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Relations to subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
