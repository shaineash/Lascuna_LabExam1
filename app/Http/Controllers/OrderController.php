<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Rice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.rice')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $rices = Rice::where('stock_quantity', '>', 0)->get();
        return view('orders.create', compact('rices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.rice_id' => 'required|exists:rices,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $order = new Order([
            'user_id' => Auth::id(),
            'total_amount' => 0,
            'status' => 'pending',
        ]);

        $totalAmount = 0;

        foreach ($validated['items'] as $item) {
            $rice = Rice::find($item['rice_id']);

            if ($rice->stock_quantity < $item['quantity']) {
                return back()->withErrors(['error' => 'Insufficient stock for ' . $rice->name]);
            }

            $itemTotal = $rice->price_per_kg * $item['quantity'];
            $totalAmount += $itemTotal;

            $orderItem = new OrderItem([
                'rice_id' => $rice->id,
                'quantity' => $item['quantity'],
                'price_per_kg' => $rice->price_per_kg,
                'total_price' => $itemTotal,
            ]);

            if (!$order->exists) {
                $order->save();
            }

            $order->orderItems()->save($orderItem);

            // Update stock
            $rice->decrement('stock_quantity', $item['quantity']);
        }

        $order->update(['total_amount' => $totalAmount]);

        // Create payment record
        $order->payment()->create([
            'amount' => $totalAmount,
            'status' => 'unpaid',
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $order->load('orderItems.rice', 'payment');
        return view('orders.show', compact('order'));
    }
}
