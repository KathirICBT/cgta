<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number', 'first_name', 'last_name', 'photo', 'email', 'phone', 'address', 
        'title', 'birth_day', 'birth_month', 'birth_year', 'gender', 'bio', 'description', 
        'join_date', 'status', 'password', 'leader', 'coupon'
    ];

    protected $hidden = ['password'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }
}
