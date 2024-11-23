<?php 


namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function getPaginatedItems($params){
        // ->addSelect([
        //     'products.*',
        //     DB::raw('(SELECT title FROM categories WHERE categories.id = products.category_id LIMIT 1) as category_title')
        // ]);
        // ->addSelect(['products.*', Category::select('title as category_title')
        //     ->whereColumn('categories.id', 'products.category_id')
        //     ->limit(1)]);
        $query = Product::query()->with('category:id,title');
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');

        $query->filter($searchQuery);
        $products = $query->orderBy('id', 'desc')->paginate($limit)->through(function($product) {
            $product->description = $product->short_description;
            return $product;
        });

        return $products->appends($params);
    }
}