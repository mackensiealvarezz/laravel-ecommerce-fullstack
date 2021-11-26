<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $product = $this->route('product');
        return $product && $this->user()->can('update', $product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'style' => 'required',
            'brand' => 'required',
            'type' => 'required',
            'url' => 'nullable|url',
            'shipping_price' => 'required|numeric',
            'note' => 'nullable',

        ];
    }
}
