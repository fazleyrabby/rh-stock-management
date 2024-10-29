<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierService
{
    public function getPaginatedItems($params)
    {
        // ->addSelect([
        //     'products.*',
        //     DB::raw('(SELECT title FROM categories WHERE categories.id = products.category_id LIMIT 1) as category_title')
        // ]);
        // ->addSelect(['products.*', Category::select('title as category_title')
        //     ->whereColumn('categories.id', 'products.category_id')
        //     ->limit(1)]);
        $query = Supplier::query();
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');

        $query->filter($searchQuery);
        $products = $query->orderBy('id', 'desc')->paginate($limit)->through(function ($product) {
            return $product;
        });

        return $products->appends($params);
    }
}
