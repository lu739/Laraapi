<?php

namespace App\Http\Requests\Api\Product;

use App\Enum\ProductStatus;
use Illuminate\Validation\Rules\Enum;

class StoreProductRequest extends ApiRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'price' => ['required', 'integer', 'min:1'],
            'count' => ['required', 'integer', 'min:0'],
            'status' => ['required', new Enum(ProductStatus::class)],
            'images' => ['array'],
            'images.*' => ['image'],
        ];
    }
}
