<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'sponsor_id', 'event_sponsor_type_id', 'payment_status', 
        'payment_method', 'transaction_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function sponsorType()
    {
        return $this->belongsTo(EventSponsorType::class);
    }
}
