<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return response()->json(Package::with('services')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'max_membercount' => 'required|integer',
            'duration' => 'required|integer',
            'service_ids' => 'array' // optional for many-to-many relation
        ]);

        $package = Package::create($request->only([
            'name', 'price', 'description', 'max_membercount', 'duration'
        ]));

        if ($request->has('service_ids')) {
            $package->services()->sync($request->service_ids);
        }

        return response()->json($package->load('services'), 201);
    }

    public function show($id)
    {
        $package = Package::with('services')->find($id);
        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        return response()->json($package, 200);
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
            'max_membercount' => 'sometimes|required|integer',
            'duration' => 'sometimes|required|integer',
            'service_ids' => 'array'
        ]);

        $package->update($request->only([
            'name', 'price', 'description', 'max_membercount', 'duration'
        ]));

        if ($request->has('service_ids')) {
            $package->services()->sync($request->service_ids);
        }

        return response()->json($package->load('services'), 200);
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        $package->services()->detach();
        $package->delete();

        return response()->json(['message' => 'Package deleted'], 200);
    }
}
