<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Inv_product;

class CreateInv_productRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return Inv_product::$rules;
    }
    public function messages()
    {
        return [
            // 'manual_code.required' => 'يجب ادخال كود المنتج',
            // 'manual_code.min' => 'كود المنتج  يجب الا يقل عن 2 رقم' ,
            // 'manual_code.max' => 'كود المنتج يجب الا يزيد عن 8 رقم' ,
            'manual_code.unique' => 'كود المنتج مكرر' ,
        ];
    }
}
