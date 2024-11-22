<?php

namespace App\Http\Requests;

use App\Models\StockMovement;
use Illuminate\Foundation\Http\FormRequest;

class StockMovementRequest extends FormRequest
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
        // // Retrieve product from route parameter or request attribute (depending on how your routes are set up)
        // $stockMovement = $this->route('stock_movements') ?? $this->stock_movement;

        // // Ensure product is an object before accessing 'id'
        // $id = $stockMovement instanceof StockMovement ? $stockMovement->id : (is_string($stockMovement) ? $stockMovement : null);
        return [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'type' => 'required|string',
        ];
    }
}
