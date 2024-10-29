<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function scopeFilter($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('phone', 'like', '%' . $searchQuery . '%')
                    ->orWhere('email', 'like', '%' . $searchQuery . '%')
                    ->orWhere('id', 'like', '%' . $searchQuery . '%');
            });
        }

        return $query;
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
