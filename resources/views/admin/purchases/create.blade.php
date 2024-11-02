@extends('admin.layouts.app')
@section('title', 'Product Create')
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
                        Products
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
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
                                <h3 class="card-title">Create new product</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-2 col-form-label required">Supplier</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="suppliers" name="supplier_id"
                                            value="">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">
                                                    {{ $supplier->name }}|Phone-{{ $supplier->phone }}</option>
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
                                    <label class="col-2 col-form-label required">Products</label>
                                    <div class="col">
                                        <select type="text" class="form-select" id="products" name="product_id">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->title }}|Price({{ $product->price }})|Qty({{ $product->quantity }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-hint">
                                            @error('category_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-2 col-form-label required">Product title</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Product Name" name="title" value="{{ old('title') }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-2 col-form-label required">Product Sku</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby=""
                                            placeholder="Product Sku" name="sku" value="{{ old('sku') }}">
                                        <small class="form-hint">
                                            @error('sku')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-2 col-form-label required">Price</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="price" placeholder="price"
                                            value="">
                                        <small class="form-hint">
                                            @error('price')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
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
        document.addEventListener("DOMContentLoaded", function() {
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
    </script>
@endpush
