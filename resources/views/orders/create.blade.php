@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4>Create New Order</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf

                    <div id="itemsContainer">
                        <div class="order-item mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Select Rice <span class="text-danger">*</span></label>
                                    <select class="form-control rice-select @error('items.0.rice_id') is-invalid @enderror" 
                                            name="items[0][rice_id]" required>
                                        <option value="">-- Select Rice --</option>
                                        @foreach($rices as $rice)
                                            <option value="{{ $rice->id }}" data-price="{{ $rice->price_per_kg }}">
                                                {{ $rice->name }} (₱{{ number_format($rice->price_per_kg, 2) }}/kg) - Stock: {{ $rice->stock_quantity }}kg
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('items.0.rice_id')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Quantity (kg) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control quantity-input @error('items.0.quantity') is-invalid @enderror" 
                                           name="items[0][quantity]" placeholder="0.00" step="0.01" required>
                                    @error('items.0.quantity')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-2 mt-4">
                                    <button type="button" class="btn btn-danger remove-item" style="display:none;">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" id="addMoreButton">Add More Items</button>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 ms-auto">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>Order Summary</h5>
                                    <div id="orderSummary">
                                        <p>No items added yet</p>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total Amount:</strong>
                                        <strong id="totalAmount">₱0.00</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-custom text-white">Create Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let itemCount = 1;
    const rices = @json($rices);

    function updateSummary() {
        let total = 0;
        let html = '<table class="table table-sm"><tbody>';

        document.querySelectorAll('.order-item').forEach((item, index) => {
            const riceSelect = item.querySelector('.rice-select');
            const quantityInput = item.querySelector('.quantity-input');

            if (riceSelect.value && quantityInput.value) {
                const meatball = rices.find(r => r.id == riceSelect.value);
                const quantity = parseFloat(quantityInput.value);
                const subtotal = meatball.price_per_kg * quantity;
                total += subtotal;

                html += `<tr>
                    <td>${meatball.name} × ${quantity}kg</td>
                    <td class="text-end">₱${subtotal.toFixed(2)}</td>
                </tr>`;
            }
        });

        html += '</tbody></table>';
        document.getElementById('orderSummary').innerHTML = html || '<p>No items added yet</p>';
        document.getElementById('totalAmount').textContent = '₱' + total.toFixed(2);
    }

    document.getElementById('addMoreButton').addEventListener('click', function() {
        const container = document.getElementById('itemsContainer');
        const newItem = document.querySelector('.order-item').cloneNode(true);
        
        newItem.querySelector('.rice-select').name = `items[${itemCount}][rice_id]`;
        newItem.querySelector('.rice-select').value = '';
        newItem.querySelector('.quantity-input').name = `items[${itemCount}][quantity]`;
        newItem.querySelector('.quantity-input').value = '';
        
        const removeBtn = newItem.querySelector('.remove-item');
        removeBtn.style.display = 'block';
        removeBtn.addEventListener('click', function() {
            newItem.remove();
            updateSummary();
        });

        newItem.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('change', updateSummary);
            el.addEventListener('input', updateSummary);
        });

        container.appendChild(newItem);
        itemCount++;
    });

    document.querySelectorAll('input, select').forEach(el => {
        el.addEventListener('change', updateSummary);
        el.addEventListener('input', updateSummary);
    });
</script>
@endsection
