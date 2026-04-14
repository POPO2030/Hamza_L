<?php

namespace App\Http\Requests\sales;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\sales\Seller;

class UpdateSellerRequest extends FormRequest
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
        $rules = Seller::$rules_update;
        
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال الاسم',
            'name.min' => 'اسم البائع يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم البائع يجب الا يزيد عن 50 حرف' ,
 
        ];
    }
}
