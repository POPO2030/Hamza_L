<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\final_product;

class Createfinal_productRequest extends FormRequest
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
        return final_product::$rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم الصنف',
            'name.unique' => 'اسم الصنف مكرر' ,
        ];
    }
}
