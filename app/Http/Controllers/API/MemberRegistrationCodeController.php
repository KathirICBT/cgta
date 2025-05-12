<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberRegistrationCode;

class MemberRegistrationCodeController extends Controller
{
    public function index()
    {
        return response()->json(MemberRegistrationCode::with(['member', 'registrationCode'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'registration_code_id' => 'required|exists:registration_codes,id',
            'used_at' => 'nullable|date',
            'usage_status' => 'required|string',
        ]);

        $code = MemberRegistrationCode::create($validated);
        return response()->json($code, 201);
    }

    public function show($id)
    {
        $code = MemberRegistrationCode::with(['member', 'registrationCode'])->findOrFail($id);
        return response()->json($code);
    }

    public function update(Request $request, $id)
    {
        $code = MemberRegistrationCode::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'sometimes|exists:members,id',
            'registration_code_id' => 'sometimes|exists:registration_codes,id',
            'used_at' => 'nullable|date',
            'usage_status' => 'sometimes|string',
        ]);

        $code->update($validated);
        return response()->json($code);
    }

    public function destroy($id)
    {
        MemberRegistrationCode::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}

