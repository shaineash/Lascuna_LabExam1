@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Welcome, {{ Auth::user()->name }}!</h2>
        <p class="text-muted">Manage your rice business efficiently</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Rice Items</h5>
                <p class="card-text display-4">{{ $ricesCount }}</p>
                <a href="{{ route('rices.index') }}" class="btn btn-custom btn-sm text-white">View Menu</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text display-4">{{ $ordersCount }}</p>
                <a href="{{ route('orders.index') }}" class="btn btn-custom btn-sm text-white">View Orders</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Unpaid Orders</h5>
                <p class="card-text display-4">{{ $unpaidCount }}</p>
                <a href="{{ route('payments.index') }}" class="btn btn-custom btn-sm text-white">Pay Now</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="card-text display-4">₱{{ number_format($totalRevenue, 2) }}</p>
                <a href="{{ route('orders.index') }}" class="btn btn-custom btn-sm text-white">Details</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('rices.create') }}" class="btn btn-primary me-2">Add New Rice</a>
                <a href="{{ route('orders.create') }}" class="btn btn-success me-2">Create Order</a>
                <a href="{{ route('rices.index') }}" class="btn btn-info">View All Products</a>
            </div>
        </div>
    </div>
</div>
@endsection
