<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public $guarded = [];

    // Define relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function scopeFilter($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where('purchase_number', 'LIKE', "%{$searchQuery}%")
                ->orWhere('total_amount', 'LIKE', "%{$searchQuery}%");
        }
    }
}
