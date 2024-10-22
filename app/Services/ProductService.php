<?php 


namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getPaginatedProducts($params){
        $query = Product::query();
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, function ($q) use ($searchQuery) {
            return $q->where(function ($subQuery) use ($searchQuery) {
                return $subQuery->where('name', 'like', '%'.$searchQuery.'%')
                                ->orWhere('description', 'like', '%'.$searchQuery.'%')
                                ->orWhere('id', 'like', '%'.$searchQuery.'%');
            });
        });
        $products = $query->orderBy('id', 'desc')->paginate($limit)->through(function($product) {
            $product->created_at = $product->created_at->diffForHumans();
            $product->description = str()->limit($product->description, 20, '...');
            return $product;
        });
        $products->appends($params);

        return $products;
    }
}