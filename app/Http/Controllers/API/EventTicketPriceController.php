<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventTicketPrice;

class EventTicketPriceController extends Controller
{
    public function index()
    {
        return response()->json(EventTicketPrice::with(['event', 'ticketType'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'price' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $ticketPrice = EventTicketPrice::create($validated);
        return response()->json($ticketPrice, 201);
    }

    public function show($id)
    {
        $ticketPrice = EventTicketPrice::with(['event', 'ticketType'])->find($id);
        if (!$ticketPrice) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($ticketPrice);
    }

    public function update(Request $request, $id)
    {
        $ticketPrice = EventTicketPrice::find($id);
        if (!$ticketPrice) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validated = $request->validate([
            'event_id' => 'sometimes|exists:events,id',
            'ticket_type_id' => 'sometimes|exists:ticket_types,id',
            'price' => 'sometimes|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $ticketPrice->update($validated);
        return response()->json($ticketPrice);
    }

    public function destroy($id)
    {
        $ticketPrice = EventTicketPrice::find($id);
        if (!$ticketPrice) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $ticketPrice->delete();
        return response()->json(['message' => 'Deleted']);
    }
}