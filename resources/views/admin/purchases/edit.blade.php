@extends('admin.layouts.app')
@section('title', 'Purchase Edit')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                        Overview
                    </div> --}}
                    <h2 class="page-title">
                        Purchase
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.purchases.index') }}" class="btn btn-danger">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                    <form action="{{ route('admin.purchases.update', $purchase->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Create new purchase</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Supplier</label>
                                <div class="col">
                                <select type="text" class="form-select" id="suppliers" name="supplier_id" value="">
                                    @foreach ($suppliers as $index => $value)
                                        <option value="{{ $index }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <small class="form-hint">
                                    @error('supplier_id')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                              </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Products</label>
                                <div class="col">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Sale price</th>
                                                <th>Price</th>
                                                <th>
                                                    <button type="button" id="add-row" class="btn btn-success">Add Row</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-table">
                                            @if(filled($purchase->purchaseProducts))
                                            @foreach ($purchase->purchaseProducts as $key => $purchaseProduct)
                                            <tr>
                                                <td>
                                                    <select type="text" class="form-select product" id="product" name="products[{{ $key }}][product_id]" value="">
                                                        <option value="" selected disabled>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}" 
                                                                data-sale-price="{{ $product->sale_price }}"
                                                                data-purchase-price="{{ $product->purchase_price }}"
                                                                @selected($purchaseProduct->product_id == $product->id)>{{ $product->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control quantity" name="products[{{ $key }}][quantity]" value="{{ $purchaseProduct->quantity }}"></td>
                                                <td><input type="number" class="form-control sale_price" readonly disabled></td>
                                                <td><input type="text" class="form-control product_price"  name="products[{{ $key }}][price]" value="{{ $purchaseProduct->price }}"></td>
                                                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                                            </tr>        
                                            @endforeach
                                            @else 
                                            <tr>
                                                <td>
                                                    <select type="text" class="form-select product" id="product" name="products[0][product_id]" value="">
                                                        <option value="" selected disabled>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                data-sale-price="{{ $product->sale_price }}" data-purchase-price="{{ $product->purchase_price }}">{{ $product->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control quantity" name="products[0][quantity]"></td>
                                                <td><input type="number" class="form-control sale_price" readonly disabled></td>
                                                <td><input type="text" class="form-control product_price"  name="products[0][price]"></td>
                                                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function () {
    	var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('suppliers'), {
            allowEmptyOption: true,
            create: true
    	}));
    });

    document.getElementById('add-row').addEventListener('click', function () {
        const table = document.getElementById('products-table');
        const rowCount = table.rows.length;
        const newRow = `
            <tr>
                <td>
                    <select class="form-select product" name="products[${rowCount}][product_id]">
                        <option value="" selected disabled>Select Product</option>
                         @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-sale-price="{{ $product->sale_price }}" data-purchase-price="{{ $product->purchase_price }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" class="form-control quantity" value="1" name="products[${rowCount}][quantity]"></td>
                <td><input type="number" class="form-control sale_price" readonly disabled></td>
                <td><input type="text" class="form-control product_price" name="products[${rowCount}][price]"></td>
                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
            </tr>`;
        table.insertAdjacentHTML('beforeend', newRow);
    });

    document.querySelectorAll('.product').forEach(product => {
        const selectedOption = product.options[product.selectedIndex];
        const row = product.closest('tr');
        const salePrice = selectedOption?.getAttribute('data-sale-price') || 0;
        const saleInput = row.querySelector('.sale_price'); 
        const quantity = row.querySelector('.quantity').value; 
        // console.log(salePrice * quantity)
        saleInput.value = parseFloat(salePrice * quantity).toFixed(2);
    });

    document.getElementById('products-table').addEventListener('input', function (event) {
        const table = document.getElementById('products-table');
        // Check if the event is from a quantity input or product select
        if (event.target.classList.contains('quantity') || event.target.classList.contains('product')) {
            const target = event.target; // The element that triggered the event
            const row = target.closest('tr'); // The row containing the inputs
            const quantityInput = row.querySelector('.quantity'); // Quantity input field
            const priceInput = row.querySelector('.product_price'); // Price input field
            const priceSelect = row.querySelector('.product'); // Product select element
            const saleInput = row.querySelector('.sale_price'); 
            priceInput.value = 0;
            saleInput.value = 0;

            // Get selected option and purchase price
            const selectedOption = priceSelect.options[priceSelect.selectedIndex];
            const purchasePrice = selectedOption?.getAttribute('data-purchase-price') || 0;
            const salePrice = selectedOption?.getAttribute('data-sale-price') || 0;
            saleInput.value = parseFloat(salePrice).toFixed(2);
            
            // Update the price input with purchase price if a product is selected
            if (target.classList.contains('product') && purchasePrice) {
                priceInput.value = parseFloat(purchasePrice).toFixed(2);
            }

            // Calculate the total price if quantity is provided
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(purchasePrice) || 0;

            if (quantity > 0 && price > 0) {
                priceInput.value = (quantity * price).toFixed(2);
                saleInput.value = (quantity * saleInput.value).toFixed(2)
            }
        }
    });

    // Delegate event listener for dynamically added rows
    document.getElementById('products-table').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
  </script>
    
@endpush
