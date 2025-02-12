<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function ticketPrices()
    {
        return $this->hasMany(EventTicketPrice::class);
    }
}
