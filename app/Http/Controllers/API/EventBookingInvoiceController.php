<?php

namespace App\Http\Controllers\API;

use App\Models\EventBookingInvoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventBookingInvoiceController extends Controller
{
    // GET /api/event-booking-invoices
    public function index()
    {
        return EventBookingInvoice::with('booking')->get();
    }

    // POST /api/event-booking-invoices
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'member_id' => 'required|exists:members,id',
            'event_id' => 'required|exists:events,id',
            'subtotal_price' => 'required|numeric',
            'tax_percentage' => 'required|numeric',
            'tax_amount' => 'required|numeric',
            'total_price' => 'required|numeric',
            'status' => 'required|in:paid,unpaid',
        ]);

        $invoice = EventBookingInvoice::create([
            'booking_id' => $request->booking_id,
            'member_id' => $request->member_id,
            'event_id' => $request->event_id,
            'subtotal_price' => $request->subtotal_price,
            'tax_percentage' => $request->tax_percentage,
            'tax_amount' => $request->tax_amount,
            'total_price' => $request->total_price,
            'invoice_number' => 'EBI-' . strtoupper(uniqid()),
            'status' => $request->status,
        ]);

        return response()->json($invoice, 201);
    }

    // GET /api/event-booking-invoices/{id}
    public function show($id)
    {
        $invoice = EventBookingInvoice::with('booking')->findOrFail($id);
        return response()->json($invoice);
    }

    // PUT /api/event-booking-invoices/{id}
    public function update(Request $request, $id)
    {
        $invoice = EventBookingInvoice::findOrFail($id);

        $request->validate([
            'status' => 'sometimes|in:paid,unpaid',
        ]);

        $invoice->update($request->only([
            'status'
        ]));

        return response()->json($invoice);
    }

    // DELETE /api/event-booking-invoices/{id}
    public function destroy($id)
    {
        $invoice = EventBookingInvoice::findOrFail($id);
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
