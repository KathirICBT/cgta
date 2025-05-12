<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberCompany;

class MemberCompanyController extends Controller
{
    public function index()
    {
        return response()->json(MemberCompany::with(['member', 'company'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'company_id' => 'required|exists:companies,id',
            'role' => 'required|string|max:255',
        ]);

        $record = MemberCompany::create($validated);
        return response()->json($record, 201);
    }

    public function show($id)
    {
        $record = MemberCompany::with(['member', 'company'])->findOrFail($id);
        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $record = MemberCompany::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'sometimes|exists:members,id',
            'company_id' => 'sometimes|exists:companies,id',
            'role' => 'sometimes|string|max:255',
        ]);

        $record->update($validated);
        return response()->json($record);
    }

    public function destroy($id)
    {
        MemberCompany::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}

