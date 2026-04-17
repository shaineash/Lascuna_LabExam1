@extends('layouts.app')

@section('title', 'Payment History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Payment History</h2>
</div>

@if($payments->isEmpty())
    <div class="alert alert-info">No payments found yet.</div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>#{{ $payment->order->id }}</td>
                        <td>₱{{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="badge {{ $payment->status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>
                            @if($payment->payment_method)
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $payment->transaction_id ?? '-' }}</td>
                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $payment->order) }}" class="btn btn-sm btn-info">View Order</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
