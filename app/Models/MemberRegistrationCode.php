<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRegistrationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'registration_code_id',
        'used_at',
        'usage_status',
    ];

    protected $casts = [
        'used_at' => 'date',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function registrationCode()
    {
        return $this->belongsTo(RegistrationCode::class);
    }
}
