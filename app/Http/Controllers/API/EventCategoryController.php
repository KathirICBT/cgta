<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        return response()->json(EventCategory::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $category = EventCategory::create($request->only(['name', 'description']));
        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = EventCategory::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $category = EventCategory::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string'
        ]);

        $category->update($request->only(['name', 'description']));
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = EventCategory::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted'], 200);
    }
}
