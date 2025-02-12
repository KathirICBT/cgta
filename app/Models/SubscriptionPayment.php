<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id', 'amount', 'tax_percentage', 'tax_amount',
        'total_amount', 'payment_method', 'transaction_id', 'status'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public static function createPayment($subscriptionId, $amount, $paymentMethod, $transactionId = null)
    {
        $subscription = Subscription::findOrFail($subscriptionId);

        // Get the latest tax percentage
        $taxPercentage = TaxSetting::getCurrentTax();
        $taxAmount = ($amount * $taxPercentage) / 100;
        $totalAmount = $amount + $taxAmount;

        // Create payment record
        $payment = self::create([
            'subscription_id' => $subscriptionId,
            'amount' => $amount,
            'tax_percentage' => $taxPercentage,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
            'status' => ($paymentMethod === 'cash') ? 'pending' : 'completed',
        ]);

        // Check if total payments cover subscription price
        $totalPaid = SubscriptionPayment::where('subscription_id', $subscriptionId)->sum('total_amount');

        if ($totalPaid >= $subscription->package->price) {
            Subscription::handleFullPayment($subscription);
        }

        return $payment;
    }
}
