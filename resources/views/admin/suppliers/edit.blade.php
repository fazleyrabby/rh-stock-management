@extends('admin.layouts.app')
@section('title', 'Supplier Edit')
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
                        Suppliers
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-danger">
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
                <form class="card" action="{{ route('admin.suppliers.update', $supplier->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h3 class="card-title">Edit supplier</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Supplier Name</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                    placeholder="Supplier Name" name="name" value="{{ $supplier->name }}">
                                <small class="form-hint">
                                    @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Phone Number</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby=""
                                    placeholder="Phone Number" name="phone" value="{{ $supplier->phone }}">
                                <small class="form-hint">
                                    @error('phone')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Email</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby=""
                                    placeholder="Email Address" name="email" value="{{ $supplier->email }}">
                                <small class="form-hint">
                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Address</label>
                            <div class="col">
                                <textarea name="address" class="form-control" id="" cols="5" rows="5">{{ $supplier->address }}</textarea>
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

