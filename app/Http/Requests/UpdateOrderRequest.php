<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'count'          => ['required', 'integer'],
            'total_price'    => ['required', 'numeric', 'min:1'],
            'products.name'  => ['required', 'string', 'max:300', 'min:3','exists:products,name'],
            'products.price' => ['required', 'numeric', 'min:1'],
        ];
    }
}
