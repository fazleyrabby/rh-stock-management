<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Customer;
use App\Services\CommonBusinessService;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CustomerService $customerService)
    {
        $customers = $customerService->getPaginatedItems($request->all());
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $customerRequest)
    {
        Customer::create($customerRequest->validated());
        return redirect()->route('admin.customers.create')->with(['success' => 'Successfully created!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CustomerRequest $customerRequest)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($customerRequest->validated());
        return redirect()->route('admin.customers.index')->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with(['success' => 'Successfully deleted!']);
    }

    public function bulkDelete(Request $request, CommonBusinessService $commonBusinessService)
    {
        $ids = $request->input('ids');
        $response = $commonBusinessService->bulkDelete($ids, 'App\Models\Customer');
        return redirect()->route('admin.customers.index')->with($response);
    }
}
