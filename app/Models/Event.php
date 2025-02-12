<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category_id', 'event_type', 'start_date', 'start_time', 
        'end_date', 'end_time', 'location', 'country', 'is_free', 'max_attendees', 
        'max_tickets_per_person', 'advertisement_image', 'banner_image', 'release_date', 
        'closing_date'
    ];

    public function category()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function sponsors()
    {
        return $this->hasMany(EventSponsor::class);
    }

    public function ticketPrices()
    {
        return $this->hasMany(EventTicketPrice::class);
    }
}
