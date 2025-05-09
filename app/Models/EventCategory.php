<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
