<?php

namespace App\Observers;

use App\Models\StockMovement;
use App\Services\StockService;

class StockMovementObserver
{
    /**
     * Handle the StockMovement "created" event.
     */
    public function created(StockMovement $stockMovement): void
    {
        StockService::updateStock($stockMovement->product_id, $stockMovement->quantity);
    }

    /**
     * Handle the StockMovement "updated" event.
     */
    public function updated(StockMovement $stockMovement): void
    {
        $quantity = $stockMovement->quantity - $stockMovement->getOriginal('quantity');
        StockService::updateStock($stockMovement->product_id, $quantity);
    }

    /**
     * Handle the StockMovement "deleted" event.
     */
    public function deleted(StockMovement $stockMovement): void
    {
        StockService::updateStock($stockMovement->product_id, -$stockMovement->quantity);
    }

    /**
     * Handle the StockMovement "restored" event.
     */
    public function restored(StockMovement $stockMovement): void
    {
        //
    }

    /**
     * Handle the StockMovement "force deleted" event.
     */
    public function forceDeleted(StockMovement $stockMovement): void
    {
        //
    }
}
