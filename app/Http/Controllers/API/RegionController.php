<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        return response()->json(Region::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $region = Region::create($request->all());
        return response()->json($region, 201);
    }

    public function show($id)
    {
        $region = Region::find($id);
        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }
        return response()->json($region, 200);
    }

    public function update(Request $request, $id)
    {
        $region = Region::find($id);
        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $region->update($request->all());
        return response()->json($region, 200);
    }

    public function destroy($id)
    {
        $region = Region::find($id);
        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }

        $region->delete();
        return response()->json(['message' => 'Region deleted'], 200);
    }
}
