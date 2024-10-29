<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends BaseController implements HasMiddleware
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // config('app.pagination.limit')
        $products = Product::query()->paginate(5);
        $productCollection = ProductResource::collection($products);
        return $this->sendPaginatedResponse(
            $productCollection,
            setPaginationMetaData($products)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error creating product: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->sendError('Product not found');
        }
        return $this->sendResponse(new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return $this->sendError('Product not found');
            }
            $product->update($request->validated());
            return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
        } catch (\Exception $e) {
            // Handle any other exceptions
            return $this->sendError('Error updating product: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return $this->sendError('Product Not found');
            }
            $product->delete();
            return $this->sendResponse('', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error deleting product: ' . $e->getMessage());
        }
    }
}
