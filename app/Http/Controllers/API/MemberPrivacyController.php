<?php

namespace App\Http\Controllers\API;

use App\Models\MemberPrivacy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberPrivacyController extends Controller
{
    public function index()
    {
        return response()->json(MemberPrivacy::with(['member', 'privacyLevel'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'field_name' => 'required|string|max:255',
            'global_private' => 'required|boolean',
            'privacy_level_id' => 'required|exists:privacy_levels,id',
        ]);

        $memberPrivacy = MemberPrivacy::create($request->all());

        return response()->json($memberPrivacy, 201);
    }

    public function show($id)
    {
        $memberPrivacy = MemberPrivacy::with(['member', 'privacyLevel'])->find($id);

        if (!$memberPrivacy) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($memberPrivacy);
    }

    public function update(Request $request, $id)
    {
        $memberPrivacy = MemberPrivacy::find($id);

        if (!$memberPrivacy) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'field_name' => 'required|string|max:255',
            'global_private' => 'required|boolean',
            'privacy_level_id' => 'required|exists:privacy_levels,id',
        ]);

        $memberPrivacy->update($request->all());

        return response()->json($memberPrivacy);
    }

    public function destroy($id)
    {
        $memberPrivacy = MemberPrivacy::find($id);

        if (!$memberPrivacy) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $memberPrivacy->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
