<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // GET /api/bookings
    public function index()
    {
        return Booking::with(['member', 'event', 'ticketType', 'invoice'])->get();
    }

    // POST /api/bookings
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'tickets_count' => 'required|integer|min:1',
            'payment_method' => 'required|in:card,paypal,bank_transfer,cash',
            'transaction_id' => 'nullable|string',
        ]);

        $booking = Booking::createBooking(
            $request->member_id,
            $request->event_id,
            $request->ticket_type_id,
            $request->tickets_count,
            $request->payment_method,
            $request->transaction_id
        );

        return response()->json($booking->load('invoice'), 201);
    }

    // GET /api/bookings/{id}
    public function show($id)
    {
        $booking = Booking::with(['member', 'event', 'ticketType', 'invoice'])->findOrFail($id);
        return response()->json($booking);
    }

    // PUT/PATCH /api/bookings/{id}
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'tickets_count' => 'sometimes|integer|min:1',
            'payment_status' => 'sometimes|in:paid,unpaid',
            'payment_method' => 'sometimes|in:card,paypal,bank_transfer,cash',
            'transaction_id' => 'nullable|string',
        ]);

        $booking->update($request->only([
            'tickets_count', 'payment_status', 'payment_method', 'transaction_id'
        ]));

        return response()->json($booking);
    }

    // DELETE /api/bookings/{id}
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
