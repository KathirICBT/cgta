<?php

namespace App\Http\Controllers\API;

use App\Models\PrivacyLevel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyLevelController extends Controller
{
    public function index()
    {
        return response()->json(PrivacyLevel::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $privacyLevel = PrivacyLevel::create($request->all());

        return response()->json($privacyLevel, 201);
    }

    public function show($id)
    {
        $privacyLevel = PrivacyLevel::find($id);

        if (!$privacyLevel) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($privacyLevel);
    }

    public function update(Request $request, $id)
    {
        $privacyLevel = PrivacyLevel::find($id);

        if (!$privacyLevel) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $privacyLevel->update($request->all());

        return response()->json($privacyLevel);
    }

    public function destroy($id)
    {
        $privacyLevel = PrivacyLevel::find($id);

        if (!$privacyLevel) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $privacyLevel->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
