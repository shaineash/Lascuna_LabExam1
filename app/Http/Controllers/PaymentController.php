<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('order')->get();

        return view('payments.index', compact('payments'));
    }

    public function pay(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        if (!$order->payment) {
            return back()->withErrors(['error' => 'No payment record found for this order.']);
        }

        return view('payments.pay', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer,card',
        ]);

        $payment = $order->payment;
        $payment->update([
            'status' => 'paid',
            'payment_method' => $validated['payment_method'],
            'transaction_id' => 'TXN-' . time(),
        ]);

        $order->update(['status' => 'completed']);

        return redirect()->route('payments.index')->with('success', 'Payment processed successfully!');
    }
}
