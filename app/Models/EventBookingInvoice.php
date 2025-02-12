<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBookingInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'member_id', 'event_id', 'subtotal_price', 
        'tax_percentage', 'tax_amount', 'total_price', 'invoice_number', 'status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public static function generateInvoice($booking)
    {
        $invoiceNumber = 'EBI-' . strtoupper(uniqid());

        return self::create([
            'booking_id' => $booking->id,
            'member_id' => $booking->member_id,
            'event_id' => $booking->event_id,
            'subtotal_price' => $booking->subtotal_price,
            'tax_percentage' => $booking->tax_percentage,
            'tax_amount' => $booking->tax_amount,
            'total_price' => $booking->total_price,
            'invoice_number' => $invoiceNumber,
            'status' => $booking->payment_status,
        ]);
    }
}
