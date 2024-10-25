<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $customer = $this->route('customer') ?? $this->customer;
        $id = $customer instanceof Customer ? $customer->id : (is_string($customer) ? $customer : null);

        return [
            'name' => 'required|string|max:120',
            'email' => 'required|unique:customers,email,' . $id,
            'phone' => 'nullable|unique:customers,phone,' . $id,
            'address' => 'required|string|max:200',
        ];
    }
}
