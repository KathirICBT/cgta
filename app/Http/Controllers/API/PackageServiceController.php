<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PackageService;
use Illuminate\Http\Request;

class PackageServiceController extends Controller
{
    public function index()
    {
        return response()->json(PackageService::with(['package', 'service'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $packageService = PackageService::create($request->only(['package_id', 'service_id']));
        return response()->json($packageService, 201);
    }

    public function show($id)
    {
        $ps = PackageService::with(['package', 'service'])->find($id);
        if (!$ps) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($ps, 200);
    }

    public function update(Request $request, $id)
    {
        $ps = PackageService::find($id);
        if (!$ps) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $request->validate([
            'package_id' => 'sometimes|required|exists:packages,id',
            'service_id' => 'sometimes|required|exists:services,id',
        ]);

        $ps->update($request->only(['package_id', 'service_id']));
        return response()->json($ps, 200);
    }

    public function destroy($id)
    {
        $ps = PackageService::find($id);
        if (!$ps) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $ps->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
