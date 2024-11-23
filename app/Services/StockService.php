<?php

namespace App\Services;

use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Log;

class StockService
{
    public static function updateStock($productId, $quantity){
        $productStock = ProductStock::firstOrNew(
            ['product_id' => $productId],  // Find or create
            ['quantity' => 0]              // Default values for new record if not found
        );
        $productStock->quantity += $quantity;
        $productStock->save(); 
    }

    public function getStockMovementPaginatedItems($params){
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