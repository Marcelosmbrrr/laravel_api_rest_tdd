<?php

namespace App\Http\Requests\Api\ProductController;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:products,name', 'min:3'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric']
        ];
    }
}
