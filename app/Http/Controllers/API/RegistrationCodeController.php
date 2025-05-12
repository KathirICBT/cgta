<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegistrationCode;
use Illuminate\Http\Request;

class RegistrationCodeController extends Controller
{
    public function index()
    {
        return response()->json(RegistrationCode::with(['company', 'member'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'member_id' => 'nullable|exists:members,id',
            'registration_code' => 'required|string|unique:registration_codes',
            'max_usage' => 'required|integer',
            'used_count' => 'nullable|integer',
            'status' => 'required|string',
            'expires_at' => 'nullable|date',
        ]);

        $code = RegistrationCode::create($validated);
        return response()->json($code, 201);
    }

    public function show($id)
    {
        $code = RegistrationCode::with(['company', 'member'])->findOrFail($id);
        return response()->json($code);
    }

    public function update(Request $request, $id)
    {
        $code = RegistrationCode::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'sometimes|exists:companies,id',
            'member_id' => 'nullable|exists:members,id',
            'registration_code' => 'sometimes|string|unique:registration_codes,registration_code,' . $id,
            'max_usage' => 'sometimes|integer',
            'used_count' => 'sometimes|integer',
            'status' => 'sometimes|string',
            'expires_at' => 'nullable|date',
        ]);

        $code->update($validated);
        return response()->json($code);
    }

    public function destroy($id)
    {
        $code = RegistrationCode::findOrFail($id);
        $code->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
