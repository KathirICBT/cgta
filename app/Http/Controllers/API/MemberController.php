<?php

namespace App\Http\Controllers\API;;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    // List all members
    public function index()
    {
        return response()->json(Member::all());
    }

    // Store a new member
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_number' => 'required|unique:members',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:members',
            'phone' => 'required',
            'address' => 'nullable|string',
            'title' => 'nullable|string',
            'birth_day' => 'nullable|numeric',
            'birth_month' => 'nullable|numeric',
            'birth_year' => 'nullable|numeric',
            'gender' => 'nullable|string',
            'bio' => 'nullable|string',
            'description' => 'nullable|string',
            'join_date' => 'nullable|date',
            'status' => 'nullable|string',
            'leader' => 'nullable|string',
            'coupon' => 'nullable|string',
            'password' => 'required|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads/members', 'public');
            $validated['photo'] = '/storage/' . $photoPath;
        }

        $validated['password'] = Hash::make($validated['password']);

        $member = Member::create($validated);

        return response()->json($member, 201);
    }

    // Show a single member
    public function show($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }
        return response()->json($member);
    }

    // Update a member
    public function update(Request $request, $id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $validated = $request->validate([
            'member_number' => 'sometimes|required|unique:members,member_number,' . $id,
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:members,email,' . $id,
            'phone' => 'sometimes|required',
            'address' => 'nullable|string',
            'title' => 'nullable|string',
            'birth_day' => 'nullable|numeric',
            'birth_month' => 'nullable|numeric',
            'birth_year' => 'nullable|numeric',
            'gender' => 'nullable|string',
            'bio' => 'nullable|string',
            'description' => 'nullable|string',
            'join_date' => 'nullable|date',
            'status' => 'nullable|string',
            'leader' => 'nullable|string',
            'coupon' => 'nullable|string',
            'password' => 'sometimes|nullable|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo) {
                $existingPath = str_replace('/storage/', '', $member->photo);
                Storage::disk('public')->delete($existingPath);
            }

            $photoPath = $request->file('photo')->store('uploads/members', 'public');
            $validated['photo'] = '/storage/' . $photoPath;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $member->update($validated);

        return response()->json($member);
    }

    // Delete a member
    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        if ($member->photo) {
            $existingPath = str_replace('/storage/', '', $member->photo);
            Storage::disk('public')->delete($existingPath);
        }

        $member->delete();

        return response()->json(['message' => 'Member deleted successfully']);
    }
}
