<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, ProductService $productService)
    {
        $products = $productService->getPaginatedProducts($request->all());
        return view('admin.products.index', compact('products'));
    }

    public function edit(Product $product)
    {
        $this->authorize('create', Product::class);
        return view('admin.products.edit', compact('product'));
    }

    public function store(ProductRequest $request)
    {
        dd(route('admin.products.create'));
        $this->authorize('create', Product::class);
        Product::create($request->validated());
        return redirect()->route('admin.products.create')->with(['success' => 'Successfully created!']);
    }


    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.product.show', compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $this->authorize('create', Product::class);
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return redirect()->route('admin.products.index')->with(['success' => 'Successfully updated!']);
    }


    public function destroy($id)
    {
        $this->authorize('delete', Product::class);
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with(['success' => 'Successfully deleted!']);
    }
}
