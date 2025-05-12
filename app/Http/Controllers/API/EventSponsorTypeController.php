<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventSponsorType;

class EventSponsorTypeController extends Controller
{
    // Display a listing of the sponsor types
    public function index()
    {
        $sponsorTypes = EventSponsorType::with('event')->get();
        return response()->json($sponsorTypes);
    }

    // Store a newly created sponsor type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'benefits' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $sponsorType = EventSponsorType::create($validated);

        return response()->json($sponsorType, 201);
    }

    // Display the specified sponsor type
    public function show($id)
    {
        $sponsorType = EventSponsorType::with('event')->find($id);
        if (!$sponsorType) {
            return response()->json(['message' => 'Sponsor type not found'], 404);
        }

        return response()->json($sponsorType);
    }

    // Update the specified sponsor type
    public function update(Request $request, $id)
    {
        $sponsorType = EventSponsorType::find($id);
        if (!$sponsorType) {
            return response()->json(['message' => 'Sponsor type not found'], 404);
        }

        $validated = $request->validate([
            'event_id' => 'sometimes|required|exists:events,id',
            'name' => 'sometimes|required|string|max:255',
            'benefits' => 'nullable|string',
            'amount' => 'sometimes|required|numeric|min:0',
        ]);

        $sponsorType->update($validated);

        return response()->json($sponsorType);
    }

    // Remove the specified sponsor type
    public function destroy($id)
    {
        $sponsorType = EventSponsorType::find($id);
        if (!$sponsorType) {
            return response()->json(['message' => 'Sponsor type not found'], 404);
        }

        $sponsorType->delete();

        return response()->json(['message' => 'Sponsor type deleted successfully']);
    }
}
