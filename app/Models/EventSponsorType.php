<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSponsorType extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'name', 'benefits', 'amount'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
