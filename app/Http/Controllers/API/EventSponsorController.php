<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventSponsor;

class EventSponsorController extends Controller
{
    // Display all event sponsors
    public function index()
    {
        $sponsors = EventSponsor::with(['event', 'sponsor', 'sponsorType'])->get();
        return response()->json($sponsors);
    }

    // Store a new event sponsor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'sponsor_id' => 'required|exists:sponsors,id',
            'event_sponsor_type_id' => 'nullable|exists:event_sponsor_types,id',
            'payment_status' => 'required|in:pending,paid,failed',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
        ]);

        $eventSponsor = EventSponsor::create($validated);

        return response()->json($eventSponsor, 201);
    }

    // Show a specific event sponsor
    public function show($id)
    {
        $sponsor = EventSponsor::with(['event', 'sponsor', 'sponsorType'])->find($id);

        if (!$sponsor) {
            return response()->json(['message' => 'Event Sponsor not found'], 404);
        }

        return response()->json($sponsor);
    }

    // Update an existing event sponsor
    public function update(Request $request, $id)
    {
        $sponsor = EventSponsor::find($id);

        if (!$sponsor) {
            return response()->json(['message' => 'Event Sponsor not found'], 404);
        }

        $validated = $request->validate([
            'event_id' => 'sometimes|required|exists:events,id',
            'sponsor_id' => 'sometimes|required|exists:sponsors,id',
            'event_sponsor_type_id' => 'nullable|exists:event_sponsor_types,id',
            'payment_status' => 'sometimes|required|in:pending,paid,failed',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
        ]);

        $sponsor->update($validated);

        return response()->json($sponsor);
    }

    // Delete a sponsor
    public function destroy($id)
    {
        $sponsor = EventSponsor::find($id);

        if (!$sponsor) {
            return response()->json(['message' => 'Event Sponsor not found'], 404);
        }

        $sponsor->delete();

        return response()->json(['message' => 'Event Sponsor deleted successfully']);
    }
}

