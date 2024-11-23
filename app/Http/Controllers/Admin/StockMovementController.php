<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockMovementRequest;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\CommonBusinessService;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, StockService $stockService)
    {
        $stockMovements = $stockService->getStockMovementPaginatedItems($request->all());
        return view('admin.stocks.movements.index', compact('stockMovements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::pluck('title', 'id');
        return view('admin.stocks.movements.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockMovementRequest $request)
    {
        $data = array_merge($request->validated(), [
            'user_id' => auth()->user()->id, // Use `auth()->id()` for brevity
        ]);
        StockMovement::create($data);
        
        return redirect()->route('admin.stocks.movement.store')->with(['success' => 'Successfully created!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stockMovement = StockMovement::with('product:id,title')->find($id);
        return view('admin.stocks.movements.show', compact('stockMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $products = Product::pluck('title', 'id');
        $stockMovement = StockMovement::findOrFail($id);
        return view('admin.stocks.movements.edit', compact('stockMovement','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockMovementRequest $request, $id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->update($request->validated());
        return redirect()->route('admin.stocks.movement.index')->with(['success' => 'Successfully updated!']);
    }

    public function destroy($id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->delete();
        return redirect()->route('admin.stocks.movement.index')->with(['success' => 'Successfully deleted!']);
    }

    public function bulkDelete(Request $request, CommonBusinessService $commonBusinessService)
    {        
        $ids = $request->input('ids');
        $response = $commonBusinessService->bulkDelete($ids, 'App\Models\StockMovement');
        return redirect()->route('admin.stocks.movement.index')->with($response);
    }
}
