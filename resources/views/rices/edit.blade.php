@extends('layouts.app')

@section('title', 'Edit Rice')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Rice Item</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('rices.update', $rice) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Rice Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" 
                               value="{{ old('name', $rice->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price_per_kg" class="form-label">Price per Kilogram <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number" class="form-control @error('price_per_kg') is-invalid @enderror" 
                                   id="price_per_kg" name="price_per_kg" 
                                   step="0.01" value="{{ old('price_per_kg', $rice->price_per_kg) }}" required>
                        </div>
                        @error('price_per_kg')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity (kg) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                               id="stock_quantity" name="stock_quantity" 
                               value="{{ old('stock_quantity', $rice->stock_quantity) }}" required>
                        @error('stock_quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $rice->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('rices.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-custom text-white">Update Rice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
