@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Order #{{ $order->id }}</h4>
                    <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Order Date</h6>
                        <p>{{ $order->created_at->format('F d, Y H:i A') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Customer</h6>
                        <p>{{ $order->user->name }}</p>
                    </div>
                </div>

                <h5 class="mb-3">Order Items</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Rice Name</th>
                                <th>Price/kg</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->rice->name }}</td>
                                    <td>₱{{ number_format($item->price_per_kg, 2) }}</td>
                                    <td>{{ $item->quantity }} kg</td>
                                    <td>₱{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6 ms-auto">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <h5>Total Amount:</h5>
                                    <h5>₱{{ number_format($order->total_amount, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Payment Information</h5>
            </div>
            <div class="card-body">
                @if($order->payment)
                    <div class="mb-3">
                        <h6 class="text-muted">Payment Status</h6>
                        <p>
                            <span class="badge {{ $order->payment->status === 'paid' ? 'bg-success' : 'bg-danger' }} p-2">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Amount Due</h6>
                        <p class="h5">₱{{ number_format($order->payment->amount, 2) }}</p>
                    </div>

                    @if($order->payment->payment_method)
                        <div class="mb-3">
                            <h6 class="text-muted">Payment Method</h6>
                            <p>{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
                        </div>
                    @endif

                    @if($order->payment->transaction_id)
                        <div class="mb-3">
                            <h6 class="text-muted">Transaction ID</h6>
                            <p>{{ $order->payment->transaction_id }}</p>
                        </div>
                    @endif

                    @if($order->payment->status === 'unpaid')
                        <div class="mt-4">
                            <a href="{{ route('payments.pay', $order) }}" class="btn btn-success w-100">Process Payment</a>
                        </div>
                    @endif
                @else
                    <p class="text-danger">No payment record found</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary w-100">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
