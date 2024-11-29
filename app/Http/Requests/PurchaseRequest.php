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
    public function rules(): array
    {
        $purchase = $this->route('purchase') ?? $this->purchase;

        $id = $purchase instanceof Purchase ? $purchase->id : (is_string($purchase) ? $purchase : null);

        return [
            'supplier_id' => 'required',
            'products' => 'required|array',
        ];
    }
}
