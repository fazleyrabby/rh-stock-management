<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\PurchaseService;
use App\Services\StockService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request, PurchaseService $purchaseService)
    {
        $purchases = $purchaseService->getPaginatedItems($request->all());
        return view('admin.purchases.index', compact('purchases'));
    }


    public function create()
    {
        $products = Product::toBase()->select('title', 'id','purchase_price','sale_price')->get();
        $suppliers = Supplier::pluck('name', 'id');
        return view('admin.purchases.create', compact('products','suppliers'));
    }

    public function show($id)
    {
        $purchase = Purchase::with('purchaseProducts.product:title,price,id','supplier:id,name')->find($id);
        return view('admin.purchases.show', compact('purchase'));
    }

    public function store(PurchaseRequest $request, PurchaseService $purchaseService)
    {
        try {
            $purchaseService->store($request->validated());
            $type = 'success';
            $message = 'Successfully created!';
        } catch (\Exception $e) {
            $type = 'error';
            $message = 'Failed to create purchase!';
        }
        return redirect()->route('admin.purchases.create')->with([$type => $message]);
    }

    public function edit(Purchase $purchase)
    {
        $products = Product::toBase()->select('title', 'id','purchase_price','sale_price')->get();
        $suppliers = Supplier::pluck('name', 'id');
        return view('admin.purchases.edit', compact('products','suppliers','purchase'));
    }

    public function update($id, PurchaseRequest $request, PurchaseService $purchaseService)
    {
        try {
            $purchaseService->update($request->validated(), $id);
            $type = 'success';
            $message = 'Successfully updated!';
        } catch (\Exception $e) {
            $type = 'error';
            $message = 'Failed to updated purchase!';
        }
        return redirect()->route('admin.purchases.index')->with([$type => $message]);
    }


    public function destroy($id, PurchaseService $purchaseService)
    {
        try {
            $purchaseService->delete($id);
            $type = 'success';
            $message = 'Successfully updated!';
        } catch (\Exception $e) {
            $type = 'error';
            $message = 'Failed to updated purchase!';
        }
        return redirect()->route('admin.purchases.index')->with([$type => $message]);
        // $stockMovement = StockMovement::findOrFail($id);
        // $stockMovement->delete();
        // return redirect()->route('admin.stocks.movement.index')->with(['success' => 'Successfully deleted!']);
    }
    
}
