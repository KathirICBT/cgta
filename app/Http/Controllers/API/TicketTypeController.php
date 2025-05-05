<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    public function index()
    {
        return response()->json(TicketType::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $ticketType = TicketType::create($request->all());

        return response()->json($ticketType, 201);
    }

    public function show($id)
    {
        $ticketType = TicketType::find($id);

        if (!$ticketType) {
            return response()->json(['message' => 'Ticket type not found'], 404);
        }

        return response()->json($ticketType, 200);
    }

    public function update(Request $request, $id)
    {
        $ticketType = TicketType::find($id);

        if (!$ticketType) {
            return response()->json(['message' => 'Ticket type not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $ticketType->update($request->all());

        return response()->json($ticketType, 200);
    }

    public function destroy($id)
    {
        $ticketType = TicketType::find($id);

        if (!$ticketType) {
            return response()->json(['message' => 'Ticket type not found'], 404);
        }

        $ticketType->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
