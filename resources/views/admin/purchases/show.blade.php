@extends('admin.layouts.app')
@section('title', 'Perchase Data')
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
                        Purchases
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
                    <div class="card-header">
                        <h3 class="card-title">Purchase preview</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Purchase Number</label>
                            <div class="col">
                                {{ $purchase->purchase_number }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Amount</label>
                            <div class="col">
                                {{ $purchase->total_amount }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Status</label>
                            <div class="col">
                                {{ $purchase->status }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Product supplier</label>
                            <div class="col">
                                {{ $purchase->supplier->name }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Purchased Products</label>
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Single Unit Price</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-table">
                                    @foreach ($purchase->purchaseProducts as $key => $purchaseProduct)
                                    <tr>
                                        <td>{{ $purchaseProduct->quantity }} x {{ $purchaseProduct->product->title }}</td>
                                        <td>{{ $purchaseProduct->quantity }}</td>
                                        <td>{{ $purchaseProduct->price / $purchaseProduct->quantity }}</td>
                                        <td>{{ $purchaseProduct->price }}</td>
                                    </tr>        
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('admin.purchases.edit', $purchase->id) }}" class="btn btn-primary">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit
                        </a>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
@endsection
