@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Orders</h2>
    <a href="{{ route('orders.create') }}" class="btn btn-custom text-white">Create New Order</a>
</div>

@if($orders->isEmpty())
    <div class="alert alert-info">No orders found. <a href="{{ route('orders.create') }}">Create one now</a></div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->orderItems->count() }} item(s)</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            @if($order->payment)
                                <span class="badge {{ $order->payment->status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">View</a>
                            @if($order->payment && $order->payment->status === 'unpaid')
                                <a href="{{ route('payments.pay', $order) }}" class="btn btn-sm btn-success">Pay</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
