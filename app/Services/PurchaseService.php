<?php 


namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class PurchaseService
{

    /**
    * Store a new purchase and its associated products.
    */
    public function store(array $data): Purchase
    {
        // Extract products from the data
        $products = $data['products'];
        unset($data['products']);
        $data['purchase_number'] = 'PUR-' . now()->format('YmdHis') . '-' . strtoupper(str()->random(10));

        // Start a database transaction
        DB::beginTransaction();
        try {
            // Create the Purchase
            $purchase = Purchase::create($data);

            $totalAmount = 0;
            // Prepare and insert the PurchaseProducts
            foreach ($products as $product) {
                $purchase->purchaseProducts()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
                $totalAmount += $product['price'];
            }

            $purchase->update(['total_amount' => $totalAmount]);
            // Commit the transaction
            DB::commit();
            return $purchase;
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            throw $e;
        }
    }
    public function getPaginatedItems($params){
        $query = Purchase::query()->with('purchaseProducts','supplier');
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');

        $query->filter($searchQuery);
        $purchases = $query->orderBy('id', 'desc')->paginate($limit)->through(function($product) {
            $product->description = $product->short_description;
            return $product;
        });

        return $purchases->appends($params);
    }
}