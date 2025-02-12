<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'name', 'logo', 'email', 'phone', 'address', 
        'website', 'region_id', 'province', 'city', 'country', 
        'description', 'joinDate', 'services', 'status'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
                    ->where('status', 'active')
                    ->where('end_date', '>=', now());
    }

    public function activate()
    {
        $this->update(['status' => 'active']);
    }
}
