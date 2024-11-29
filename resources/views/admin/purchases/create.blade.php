@extends('admin.layouts.app')
@section('title', 'Purchase Create')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
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
                <form action="{{ route('admin.purchases.store') }}" method="post">
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
                                            <th>Price</th>
                                            <th>
                                                <button type="button" id="add-row" class="btn btn-success">Add Row</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-table">
                                        <tr>
                                            <td>
                                                <select type="text" class="form-select" id="product" name="products[0][product_id]" value="">
                                                    @foreach ($products as $index => $value)
                                                        <option value="{{ $index }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control" name="products[0][quantity]"></td>
                                            <td><input type="text" class="form-control"  name="products[0][price]"></td>
                                            <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                                        </tr>
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
    	window.TomSelect && (new TomSelect(el = document.getElementById('categories'), {
            allowEmptyOption: true,
            create: true
    	}));

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
                    <select class="form-select" name="products[${rowCount}][product_id]">
                        @foreach ($products as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" class="form-control" name="products[${rowCount}][quantity]"></td>
                <td><input type="text" class="form-control" name="products[${rowCount}][price]"></td>
                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
            </tr>`;
        table.insertAdjacentHTML('beforeend', newRow);
    });

    // Delegate event listener for dynamically added rows
    document.getElementById('products-table').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
  </script>
    
@endpush