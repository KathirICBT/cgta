<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClientCompanyEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientCompanyEventController extends Controller
{
    public function index()
    {
        $events = ClientCompanyEvent::with('company')->get();
        return response()->json($events, 200);
    }

    public function show($id)
    {
        $event = ClientCompanyEvent::with('company')->findOrFail($id);
        return response()->json($event, 200);
    }

    public function store(Request $request)
    {
        \Log::info('Store method called');


        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_link' => 'nullable|url',
            'event_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:event_date',
            'location' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        \Log::info($request->all());

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $path = $file->store('uploads/clientevents', 'public');
            $validated['banner_image'] = '/storage/' . $path;
        }

        $event = ClientCompanyEvent::create($validated);
        return response()->json($event, 201);
    }

    public function update(Request $request, $id)
    {
        $event = ClientCompanyEvent::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'nullable|exists:companies,id',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'event_link' => 'nullable|url',
            'event_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after_or_equal:event_date',
            'location' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($event->banner_image && Storage::disk('public')->exists(str_replace('/storage/', '', $event->banner_image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $event->banner_image));
            }

            $path = $request->file('banner_image')->store('uploads/clientevents', 'public');
            $validated['banner_image'] = '/storage/' . $path;
        }

        $event->update($validated);
        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $event = ClientCompanyEvent::findOrFail($id);

        if ($event->banner_image && Storage::disk('public')->exists(str_replace('/storage/', '', $event->banner_image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $event->banner_image));
        }

        $event->delete();
        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}
