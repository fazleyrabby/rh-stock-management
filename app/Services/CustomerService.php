<?php 

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function getPaginatedItems($params){
        $query = Customer::query();
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, function ($q) use ($searchQuery) {
            return $q->where(function ($subQuery) use ($searchQuery) {
                return $subQuery->where('name', 'like', '%'.$searchQuery.'%')
                                ->orWhere('id', 'like', '%'.$searchQuery.'%');
            });
        });
        $customers = $query->orderBy('id', 'desc')->paginate($limit)->through(function($customer) {
            $customer->created_at = $customer->created_at->diffForHumans();
            $customer->address = $customer->short_address;
            return $customer;
        });
        $customers->appends($params);
        
        return $customers;
    }
}