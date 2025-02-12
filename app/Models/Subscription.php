<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionInvoiceMail;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'package_id', 'start_date', 'end_date', 'status', 'payment_status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function isExpired()
    {
        return Carbon::parse($this->end_date)->isPast();
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public static function renewSubscription($companyId, $packageId)
    {
        $lastSubscription = self::where('company_id', $companyId)->latest('end_date')->first();

        $startDate = $lastSubscription ? Carbon::parse($lastSubscription->end_date)->addDay() : now();
        $endDate = Carbon::parse($startDate)->addYear();

        return self::create([
            'company_id' => $companyId,
            'package_id' => $packageId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
            'payment_status' => 'unpaid',
        ]);
    }

    public static function handleFullPayment($subscription)
    {
        // Update subscription payment status
        $subscription->update(['payment_status' => 'paid']);

        // Send Invoice Email
        Mail::to($subscription->company->email)->send(new SubscriptionInvoiceMail($subscription));
    }
}
