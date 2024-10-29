@extends('admin.layouts.app')
@section('title', 'customer Create')
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
                        Customers
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-danger">
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
                <form action="{{ route('admin.customers.update', $customer->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Create new customer</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Customer Name</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                    placeholder="customer Name" name="name" value="{{ $customer->name }}">
                                <small class="form-hint">
                                    @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Customer Email</label>
                            <div class="col">
                                <input type="email" class="form-control" aria-describedby="emailHelp"
                                    placeholder="customer email" name="email" value="{{ $customer->email }}">
                                <small class="form-hint">
                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Customer phone number</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                    placeholder="customer email" name="phone" value="{{ $customer->phone }}">
                                <small class="form-hint">
                                    @error('phone')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Customer address</label>
                            <div class="col">
                                <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ $customer->address }}</textarea>
                                <small class="form-hint">
                                    @error('address')
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
