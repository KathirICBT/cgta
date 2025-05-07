<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberPrivacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'field_name',
        'global_private',
        'privacy_level_id'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function privacyLevel()
    {
        return $this->belongsTo(PrivacyLevel::class);
    }
}
