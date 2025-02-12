<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'name', 'logo', 'email', 'phone', 'address', 'website'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function eventSponsors()
    {
        return $this->hasMany(EventSponsor::class);
    }
}
