<?php

namespace App\Models;

// use App\Observers\StockMovementObserver;
use App\Observers\StockMovementObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([StockMovementObserver::class])]
class StockMovement extends Model
{
    use HasFactory;
    public $guarded = [];

    // protected static function booted()
    // {
    //     // static::created(function (StockMovement $stockMovement) {});
    //     // static::updated(function () {});
    //     static::deleted(function () {});
        
    //     parent::booted();
    //     static::observe(StockMovementObserver::class);
    // }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeFilter($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('id', 'like', '%' . $searchQuery . '%');
            })->orWhereHas('product', function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%');
            });
        }

        return $query;
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
