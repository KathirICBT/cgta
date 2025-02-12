<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id', 'company_id', 'amount', 'tax_percentage',
        'tax_amount', 'total_amount', 'invoice_number', 'status'
    ];

    public static function generateForSubscription($subscription)
    {
        $invoiceNumber = 'INV-' . strtoupper(uniqid());

        return self::create([
            'subscription_id' => $subscription->id,
            'company_id' => $subscription->company_id,
            'amount' => $subscription->package->price,
            'tax_percentage' => TaxSetting::getCurrentTax(),
            'tax_amount' => ($subscription->package->price * TaxSetting::getCurrentTax()) / 100,
            'total_amount' => $subscription->package->price + ($subscription->package->price * TaxSetting::getCurrentTax()) / 100,
            'invoice_number' => $invoiceNumber,
            'status' => 'paid'
        ]);
    }
}
