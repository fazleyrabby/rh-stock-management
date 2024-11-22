<?php

namespace App\Services;

use App\Models\StockMovement;

class StockService
{
    public function getStockMovementPaginatedItems($params){
        // ->addSelect([
        //     'products.*',
        //     DB::raw('(SELECT title FROM categories WHERE categories.id = products.category_id LIMIT 1) as category_title')
        // ]);
        // ->addSelect(['products.*', Category::select('title as category_title')
        //     ->whereColumn('categories.id', 'products.category_id')
        //     ->limit(1)]);
        $query = StockMovement::query()->with('product:id,title');
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');

        $query->filter($searchQuery);
        $stockMovements = $query->orderBy('id', 'desc')
                    ->paginate($limit)
                    ->through(function($stockMovement) {
                        $stockMovement->created_at = $stockMovement->created_at_human;
                        return $stockMovement;
                    });

        return $stockMovements->appends($params);
    }
}