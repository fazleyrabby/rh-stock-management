<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\CommonBusinessService;
use App\Services\ProductService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, ProductService $productService)
    {
        $products = $productService->getPaginatedItems($request->all());
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::pluck('title', 'id');
        return view('admin.products.create', compact('categories'));
    }

    public function edit(Product $product)
    {
        $this->authorize('create', Product::class);
        $categories = Category::pluck('title', 'id');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function store(ProductRequest $request)
    {;
        $this->authorize('create', Product::class);
        Product::create($request->validated());
        return redirect()->route('admin.products.create')->with(['success' => 'Successfully created!']);
    }


    public function show($id)
    {
        $product = Product::with('category:id,title')->find($id);
        return view('admin.products.show', compact('product'));
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

    public function bulkDelete(Request $request, CommonBusinessService $commonBusinessService)
    {
        $ids = $request->input('ids');
        $response = $commonBusinessService->bulkDelete($ids, 'App\Models\Product');
        return redirect()->route('admin.products.index')->with($response);
    }
}
