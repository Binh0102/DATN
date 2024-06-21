<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'category_id' => ['required'],
            'name' => ['nullable'],
            'quantity' => ['required'],
            'price' => ['required'],
            'discount' => ['nullable'],
            'description' => ['nullable'],
            'variants.*' => ['nullable'],
            'variants.*.id' => [
                'nullable',
                'max:255'
            ],
            'variants.*.color' => [
                'nullable',
                'max:255'
            ],
            'variants.*.image' => [
                'nullable',
            ]
        ];
    }
}
