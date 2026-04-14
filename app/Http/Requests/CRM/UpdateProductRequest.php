<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Product;

class UpdateProductRequest extends FormRequest
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
        $rules_update = Product::$rules_update;
        
        return $rules_update;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم الصنف',
            'name.min' => 'يجب ان لا يقل اسم الصنف عن 2 حرف.',
            'name.max' => 'يجب ان لا يزيد اسم الصنف عن 50 حرف.',
            'category_id.required' => 'يجب ادخال مجموعه الصنف',
        ];
    }
}
