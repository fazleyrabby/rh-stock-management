<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Services\CommonBusinessService;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SupplierController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, SupplierService $supplierService)
    {
        $suppliers = $supplierService->getPaginatedItems($request->all());
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        $this->authorize('create', Supplier::class);
        Supplier::create($request->validated());
        return redirect()->route('admin.suppliers.create')->with(['success' => 'Successfully created!']);
    }

    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $this->authorize('create', Supplier::class);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, $id)
    {
        $this->authorize('create', Supplier::class);
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->validated());
        return redirect()->route('admin.suppliers.index')->with(['success' => 'Successfully updated!']);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Supplier::class);
        $product = Supplier::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.suppliers.index')->with(['success' => 'Successfully deleted!']);
    }

    public function bulkDelete(Request $request, CommonBusinessService $commonBusinessService)
    {
        $this->authorize('delete', Supplier::class);
        
        $ids = $request->input('ids');
        $response = $commonBusinessService->bulkDelete($ids, 'App\Models\Supplier');
        return redirect()->route('admin.suppliers.index')->with($response);
    }
}
