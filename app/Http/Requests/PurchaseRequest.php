<?php

namespace App\Http\Requests;

use App\Models\Purchase;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     $purchase = $this->route('purchase') ?? $this->purchase;

    //     $id = $purchase instanceof Purchase ? $purchase->id : (is_string($purchase) ? $purchase : null);

    //     return [
    //         'supplier_id' => 'required',
    //         'products' => 'required|array',
    //         'products.*.product_id' => 'required|integer',
    //         'products.*.quantity' => 'required|integer|min:1',
    //         'products.*.price' => 'required|numeric|min:0',
    //     ];
    // }
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'products.*.product_id.required' => 'Each product must have a valid Product ID.',
            'products.*.product_id.exists' => 'The selected Product ID does not exist in our records.',
            'products.*.quantity.required' => 'Please specify the quantity for each product.',
            'products.*.quantity.min' => 'The quantity for a product must be at least 1.',
            'products.*.price.required' => 'Each product must have a price specified.',
            'products.*.price.min' => 'The price for a product must be greater than 0.',
        ];
    }

    // public function withValidator($validator)
    // {
    //     // Add custom validation for price vs. sale price
    //     $validator->after(function ($validator) {
    //         foreach ($this->input('products', []) as $index => $product) {
    //             if (isset($product['price']) && $product['price'] <= $product['sale_price']) {
    //                 $validator->errors()->add(
    //                     "products.$index.price",
    //                     'The price must be greater than the sale price.'
    //                 );
    //             }
    //         }
    //     });
    // }
}
