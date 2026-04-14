<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Inv_unit;

class CreateInv_unitRequest extends FormRequest
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
        return Inv_unit::$rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'عفوآ...يجب ادخال اسم وحده القياس',
            'name.min' => 'عفوآ...اسم وحده القياس  يجب الا يقل عن 2 احرف' ,
            'name.max' => 'عفوآ...اسم وحده القياس يجب الا يزيد عن 50 حرف' ,
            'name.unique' => 'عفوآ...اسم وحدة القياس مكرر' ,
        ];
    }
}
