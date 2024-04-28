<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'max:300', 'min:3'],
            'price'                 => ['required', 'numeric', 'min:1'],
            'inventory.quantity'    => ['required', 'integer', 'gt:0'],
            'inventory.description' => ['nullable', 'string']
        ];
    }
}
