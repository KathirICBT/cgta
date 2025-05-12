<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        return Event::with(['category', 'sponsors', 'ticketPrices'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:event_categories,id',
            'event_type' => 'required|string',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'location' => 'required|string',
            'country' => 'required|string',
            'is_free' => 'required|boolean',
            'max_attendees' => 'nullable|integer|min:1',
            'max_tickets_per_person' => 'nullable|integer|min:1',
            'advertisement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'release_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after_or_equal:release_date',
        ]);

        // Handle advertisement_image upload
        if ($request->hasFile('advertisement_image')) {
            $adPath = $request->file('advertisement_image')->store('uploads/events/ads', 'public');
            $validated['advertisement_image'] = '/storage/' . $adPath;
        }

        // Handle banner_image upload
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('uploads/events/banners', 'public');
            $validated['banner_image'] = '/storage/' . $bannerPath;
        }

        $event = Event::create($validated);

        return response()->json($event, 201);
    }


    public function show(Event $event)
    {
        return $event->load(['category', 'sponsors', 'ticketPrices']);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:event_categories,id',
            'event_type' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date',
            'start_time' => 'sometimes|required',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable',
            'location' => 'sometimes|required|string',
            'country' => 'sometimes|required|string',
            'is_free' => 'sometimes|boolean',
            'max_attendees' => 'nullable|integer',
            'max_tickets_per_person' => 'nullable|integer',
            'advertisement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'release_date' => 'nullable|date',
            'closing_date' => 'nullable|date',
        ]);

        // Handle advertisement_image upload
        if ($request->hasFile('advertisement_image')) {
            if ($event->advertisement_image) {
                $existingPath = str_replace('/storage/', '', $event->advertisement_image);
                Storage::disk('public')->delete($existingPath);
            }

            $imagePath = $request->file('advertisement_image')->store('uploads/events/ads', 'public');
            $validated['advertisement_image'] = '/storage/' . $imagePath;
        }

        // Handle banner_image upload
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                $existingPath = str_replace('/storage/', '', $event->banner_image);
                Storage::disk('public')->delete($existingPath);
            }

            $bannerPath = $request->file('banner_image')->store('uploads/events/banners', 'public');
            $validated['banner_image'] = '/storage/' . $bannerPath;
        }

        $event->update($validated);

        return response()->json($event);
    }


    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }
}
