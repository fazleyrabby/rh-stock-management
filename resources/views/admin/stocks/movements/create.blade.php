@extends('admin.layouts.app')
@section('title', 'Stock Movement')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Stock Movements
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.stocks.movement.index') }}" class="btn btn-danger">
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
                <form action="{{ route('admin.stocks.movement.store') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Create new stock movement</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Products</label>
                            <div class="col">
                            <select type="text" class="form-select" id="product" name="product_id">
                                @foreach ($products as $index => $product)
                                    <option value="{{ $index }}">{{ $product }}</option>
                                @endforeach
                            </select>
                            <small class="form-hint">
                                @error('product_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </small>
                          </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Movement Type</label>
                            <div class="col">
                                <select type="text" class="form-select" id="type" name="type">
                                    <option value="in">In</option>
                                    <option value="out">Out</option>
                                    <option value="damage">Damage</option>
                                </select>
                                <small class="form-hint">
                                    @error('type')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Quantity</label>
                            <div class="col">
                                <input type="number" class="form-control" name="quantity" placeholder="quantity" value="">
                                <small class="form-hint">
                                    @error('quantity')
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
    document.addEventListener("DOMContentLoaded", function () {
    	var el;
    	window.TomSelect && (new TomSelect(el = document.getElementById('product'), {
            allowEmptyOption: true,
            create: true
    	}));
    });
  </script>
    
@endpush