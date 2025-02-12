<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxSetting extends Model
{
    use HasFactory;

    protected $fillable = ['tax_percentage'];

    public static function getCurrentTax()
    {
        return self::latest()->value('tax_percentage') ?? 0;
    }
}
