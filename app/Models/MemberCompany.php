<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'company_id',
        'role',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
