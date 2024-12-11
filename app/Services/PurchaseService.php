<?php 


namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

                $stockMovements = [
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'], // Negative to revert the stock
                    'type' => 'in',
                    'user_id' => auth()->user()->id
                    // 'purchase_id' => $purchase->id,
                ];
                StockMovement::create($stockMovements);
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

    public function update(array $data, $id): Purchase
    {
        // Extract products from the data
        $products = $data['products'];
        unset($data['products']);
        // $data['purchase_number'] = 'PUR-' . now()->format('YmdHis') . '-' . strtoupper(str()->random(10));
        $data['total_amount'] = collect($products)->sum('price');
        // Start a database transaction

        DB::beginTransaction();
        try {
            // Find the Purchase
            $purchase = Purchase::findOrFail($id);
            $purchase->update($data);
            // Delete old PurchaseProducts and adjust stock accordingly
            $oldProducts = $purchase->purchaseProducts;
            foreach ($oldProducts as $oldProduct) { 
                $stockMovements = [
                    'product_id' => $oldProduct->product_id,
                    'quantity' => -$oldProduct->quantity, // Negative to revert the stock
                    'type' => 'purchase_revert',
                    'user_id' => auth()->user()->id
                    // 'purchase_id' => $purchase->id,
                ];
                StockMovement::create($stockMovements);
            }
            // Delete all old purchase products
            $purchase->purchaseProducts()->delete();
            $productData = [];
            // Insert the new products and log stock movement
            foreach ($products as $product) {
                $productData[] = [
                    'product_id' => $product['product_id'],
                    'purchase_id' => $purchase->id,
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ];
                $stockMovements = [
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'], // Negative to revert the stock
                    'type' => 'in',
                    'user_id' => auth()->user()->id
                    // 'purchase_id' => $purchase->id,
                ];
                StockMovement::create($stockMovements);
            }
            // Bulk insert the new products
            $purchase->purchaseProducts()->insert($productData);
            
            // Commit the transaction
            DB::commit();
            return $purchase;
        } catch (\Exception $e) {
            // Rollback the transaction on error
            Log::error($e);
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        // Start a database transaction
        DB::beginTransaction();
        try {
            // Find the Purchase
            $purchase = Purchase::findOrFail($id);
            $oldProducts = $purchase->purchaseProducts;

            // Log stock movement for the deleted products (negative quantity to reverse stock)
            foreach ($oldProducts as $oldProduct) {
                $stockMovements = [
                    'product_id' => $oldProduct->product_id,
                    'quantity' => -$oldProduct->quantity,  // Negative to revert the stock
                    'type' => 'out',           // Type indicating it's a delete operation
                    'user_id' => auth()->user()->id
                    // 'purchase_id' => $purchase->id,   // Optional if you want to associate with the purchase
                ];
                StockMovement::create($stockMovements);
            }

            $purchase->purchaseProducts()->delete();
            $purchase->delete();

            // Commit the transaction
            DB::commit();
            return true;
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    public function bulkDelete($ids)
    {
        // Start a database transaction
        DB::beginTransaction();
        try {
            // Retrieve Purchases with their related PurchaseProducts using eager loading
            $purchases = Purchase::with('purchaseProducts')->whereIn('id', $ids)->get();

            foreach ($purchases as $purchase) {
                $oldProducts = $purchase->purchaseProducts;
                // Log stock movement for the deleted products (negative quantity to reverse stock)
                foreach ($oldProducts as $oldProduct) {
                    $stockMovements = [
                        'product_id' => $oldProduct->product_id,
                        'quantity' => -$oldProduct->quantity,  // Negative to revert the stock
                        'type' => 'out',                       // Indicates stock reduction
                        'user_id' => auth()->user()->id,
                    ];
                    StockMovement::create($stockMovements);
                }

                // Delete associated PurchaseProducts
                $purchase->purchaseProducts()->delete();

                // Delete the Purchase record itself
                $purchase->delete();
            }

            // Commit the transaction
            DB::commit();
            return true;
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            Log::error($e);
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