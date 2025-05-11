<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;


class SponsorController extends Controller
{
    public function index()
    {
        return Sponsor::with('member')->latest()->get();
    }

        
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('uploads/sponsors', 'public');
            $validated['logo'] = '/storage/' . $logoPath;
        }

        $sponsor = Sponsor::create($validated);

        return response()->json($sponsor, 201);
    }



    public function show($id)
    {
        return Sponsor::with('member')->findOrFail($id);
    }

    

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id',
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'email' => 'nullable|email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'website' => 'nullable|url',
    ]);

    $sponsor = Sponsor::findOrFail($id);

    // Handle logo file if uploaded
    if ($request->hasFile('logo')) {
        // Delete old logo file
        if ($sponsor->logo) {
            $existingPath = str_replace('/storage/', '', parse_url($sponsor->logo, PHP_URL_PATH));
            Storage::disk('public')->delete($existingPath);
        }

        // Store new logo and set full URL
        $logoPath = $request->file('logo')->store('uploads/sponsors', 'public');
        $validated['logo'] = asset('storage/' . $logoPath);
    }

    $sponsor->update($validated);

    return response()->json($sponsor);
}

    public function destroy($id)
    {
        Sponsor::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
