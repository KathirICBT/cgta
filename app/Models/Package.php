<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'max_membercount', 'duration'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'package_services');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
