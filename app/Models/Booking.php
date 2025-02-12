<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventBookingInvoiceMail;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'event_id', 'ticket_type_id', 'booking_date', 
        'tickets_count', 'subtotal_price', 'tax_percentage', 'tax_amount', 
        'total_price', 'payment_status', 'payment_method', 'transaction_id'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function invoice()
    {
        return $this->hasOne(EventBookingInvoice::class);
    }

    public static function createBooking($memberId, $eventId, $ticketTypeId, $ticketsCount, $paymentMethod, $transactionId = null)
    {
        $ticketPrice = TicketType::findOrFail($ticketTypeId)->price;
        $subtotal = $ticketPrice * $ticketsCount;
        $taxPercentage = TaxSetting::getCurrentTax();
        $taxAmount = ($subtotal * $taxPercentage) / 100;
        $totalPrice = $subtotal + $taxAmount;

        $booking = self::create([
            'member_id' => $memberId,
            'event_id' => $eventId,
            'ticket_type_id' => $ticketTypeId,
            'booking_date' => now(),
            'tickets_count' => $ticketsCount,
            'subtotal_price' => $subtotal,
            'tax_percentage' => $taxPercentage,
            'tax_amount' => $taxAmount,
            'total_price' => $totalPrice,
            'payment_status' => ($paymentMethod === 'cash') ? 'unpaid' : 'paid',
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
        ]);

        // Generate Invoice
        $invoice = EventBookingInvoice::generateInvoice($booking);

        // Send Invoice Email
        Mail::to($booking->member->email)->send(new EventBookingInvoiceMail($invoice));

        return $booking;
    }
}
