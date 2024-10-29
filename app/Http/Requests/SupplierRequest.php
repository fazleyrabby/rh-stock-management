<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
        $supplier = $this->route('product') ?? $this->supplier;

        // Ensure product is an object before accessing 'id'
        $id = $supplier instanceof Supplier ? $supplier->id : (is_string($supplier) ? $supplier : null);

        return [
            'name' => 'required|max:100',
            'phone' => 'required|string|max:20|unique:suppliers,phone,' . $id,
            'email' => 'required|email',
            'address' => 'required|max:250',
        ];
    }
}
