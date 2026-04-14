<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Inv_category;

class CreateInv_categoryRequest extends FormRequest
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
        return Inv_category::$rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم المجموعه',
            'name.min' => 'اسم المجموعه  يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم المجموعه يجب الا يزيد عن 50 حرف' ,
            'name.unique' => 'اسم المجموعه مكرر' ,
        ];
    }
}
