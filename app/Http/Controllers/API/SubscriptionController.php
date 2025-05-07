<?php

namespace App\Http\Controllers\API;

use App\Models\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return response()->json(
            Subscription::with(['company', 'package', 'payments'])->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
            'payment_status' => 'required|in:paid,unpaid'
        ]);

        $subscription = Subscription::create($request->all());

        return response()->json($subscription, 201);
    }

    public function show($id)
    {
        $subscription = Subscription::with(['company', 'package', 'payments'])->find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($subscription);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
            'payment_status' => 'required|in:paid,unpaid'
        ]);

        $subscription->update($request->all());

        return response()->json($subscription);
    }

    public function destroy($id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $subscription->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function renew(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'package_id' => 'required|exists:packages,id',
        ]);

        $subscription = Subscription::renewSubscription($request->company_id, $request->package_id);

        return response()->json($subscription, 201);
    }

    public function markAsPaid($id)
    {
        $subscription = Subscription::with('company')->find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        Subscription::handleFullPayment($subscription);

        return response()->json(['message' => 'Payment marked as paid and invoice sent.']);
    }
}
