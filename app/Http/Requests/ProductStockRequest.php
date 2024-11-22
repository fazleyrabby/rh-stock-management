<?php

namespace App\Http\Requests;

use App\Models\ProductStock;
use Illuminate\Foundation\Http\FormRequest;

class ProductStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Retrieve product from route parameter or request attribute (depending on how your routes are set up)
        $product_stock = $this->route('product_stocks') ?? $this->product_stock;

        // Ensure product is an object before accessing 'id'
        $id = $product_stock instanceof ProductStock ? $product_stock->id : (is_string($product_stock) ? $product_stock : null);
        
        return [
            'product_id' => 'required|integer|unique:product_stocks,product_id,' . $id,
            'user_id' => 'required|integer',
            'quantity' => 'required|integer',
        ];
    }
}
