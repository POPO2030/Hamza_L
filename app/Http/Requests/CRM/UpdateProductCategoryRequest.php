<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\ProductCategory;

class UpdateProductCategoryRequest extends FormRequest
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
        $rules_update = ProductCategory::$rules_update;
        
        return $rules_update;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال مجموعه المنتجات',
            'name.min' => 'يجب ان لا يقل اسم مجموعه المنتجات عن 2 حرف.',
            'name.max' => 'يجب ان لا يزيد اسم مجموعه المنتجات عن 50 حرف.',
        ];
    }
}
