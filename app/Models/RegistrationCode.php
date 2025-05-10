<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'member_id',
        'registration_code',
        'max_usage',
        'used_count',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
