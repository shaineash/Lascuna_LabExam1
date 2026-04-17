@extends('layouts.app')

@section('title', 'Process Payment')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Process Payment for Order #{{ $order->id }}</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Total Amount Due:</strong>
                    <h3 class="mt-2">₱{{ number_format($order->payment->amount, 2) }}</h3>
                </div>

                <form action="{{ route('payments.processPayment', $order) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                        <select class="form-control @error('payment_method') is-invalid @enderror" 
                                id="payment_method" name="payment_method" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Credit/Debit Card</option>
                        </select>
                        @error('payment_method')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6>Order Details</h6>
                            <table class="table table-sm">
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->rice->name }} × {{ $item->quantity }}kg</td>
                                            <td class="text-end">₱{{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-borderless border-top">
                                        <td><strong>Total</strong></td>
                                        <td class="text-end"><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-custom text-white">Confirm Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
