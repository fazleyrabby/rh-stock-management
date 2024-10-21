<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProductController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            // new Middleware('auth:sanctum', only: ['store','update'])
        ];
    }


    public function index(Request $request)
    {
        $searchQuery = $request->q;
        $query = Product::query();
        $query->when($searchQuery, function ($q) use ($searchQuery) {
            return $q->where(function ($subQuery) use ($searchQuery) {
                return $subQuery->where('name', 'like', '%'.$searchQuery.'%')
                                ->orWhere('description', 'like', '%'.$searchQuery.'%')
                                ->orWhere('id', 'like', '%'.$searchQuery.'%');
            });
        });
        $products = $query->paginate(10)->through(function($product) {
            $product->created_at = $product->created_at->diffForHumans();
            $product->description = str()->limit($product->description, 20, '...');
            return $product;
        });
        return view('admin.products.index', compact('products'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error creating product: ' . $e->getMessage(), [], 500);
        }
    }


    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->sendError('Product not found');
        }
        return $this->sendResponse(new ProductResource($product));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return redirect()->route('admin.products.index')->with(['success' => true, 'message' => 'Successfully updated!']);
    }


    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if(!$product){
                return $this->sendError('Product Not found');
            }
            $product->delete();
            return $this->sendResponse('', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error deleting product: ' . $e->getMessage());
        }
    }
}
