<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPayment;
use App\Models\Subscription;
use App\Models\TaxSetting;

class SubscriptionPaymentController extends Controller
{
    // GET /api/subscription-payments
    public function index()
    {
        return SubscriptionPayment::with('subscription')->get();
    }

    // POST /api/subscription-payments
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
        ]);

        $payment = SubscriptionPayment::createPayment(
            $request->subscription_id,
            $request->amount,
            $request->payment_method,
            $request->transaction_id
        );

        return response()->json($payment, 201);
    }

    // GET /api/subscription-payments/{id}
    public function show($id)
    {
        $payment = SubscriptionPayment::with('subscription')->findOrFail($id);
        return response()->json($payment);
    }

    // PUT /api/subscription-payments/{id}
    public function update(Request $request, $id)
    {
        $payment = SubscriptionPayment::findOrFail($id);

        $request->validate([
            'status' => 'sometimes|in:completed,pending',
        ]);

        $payment->update($request->only(['status']));

        return response()->json($payment);
    }

    // DELETE /api/subscription-payments/{id}
    public function destroy($id)
    {
        $payment = SubscriptionPayment::findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
