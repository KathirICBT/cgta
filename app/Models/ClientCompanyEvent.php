<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCompanyEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'name', 'description', 'event_link', 
        'event_date', 'closing_date', 'location', 'banner_image'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
