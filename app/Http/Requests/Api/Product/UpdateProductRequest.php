<?php

namespace App\Http\Requests\Api\Product;

use App\Enum\ProductStatus;
use Illuminate\Validation\Rules\Enum;

class UpdateProductRequest extends ApiRequest
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
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'integer', 'min:1'],
            'count' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', new Enum(ProductStatus::class)],
        ];
    }
}
