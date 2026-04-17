@extends('layouts.app')

@section('title', 'Rice Menu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Rice Menu</h2>
    <a href="{{ route('rices.create') }}" class="btn btn-custom text-white">Add New Rice</a>
</div>

@if($rices->isEmpty())
    <div class="alert alert-info">No rice items found. <a href="{{ route('rices.create') }}">Add one now</a></div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Price per kg</th>
                    <th>Stock Quantity</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rices as $rice)
                    <tr>
                        <td>{{ $rice->name }}</td>
                        <td>₱{{ number_format($rice->price_per_kg, 2) }}</td>
                        <td>
                            <span class="badge {{ $rice->stock_quantity > 10 ? 'bg-success' : ($rice->stock_quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $rice->stock_quantity }} kg
                            </span>
                        </td>
                        <td>{{ Str::limit($rice->description, 50) }}</td>
                        <td>
                            <a href="{{ route('rices.edit', $rice) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('rices.destroy', $rice) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
