<?php

namespace App\Http\Requests;

use App\Models\Product;
use Hamcrest\Type\IsString;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $product = $this->route('product') ?? $this->product;

        // Ensure product is an object before accessing 'id'
        $id = $product instanceof Product ? $product->id : (is_string($product) ? $product : null);

        return [
            'title' => 'required|string|max:120|unique:products,title,' . $id,
            'description' => 'nullable|string|max:200',
            'sku' => 'required|string|max:200|unique:products,sku,' . $id,
            'category_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ];
    }
}
