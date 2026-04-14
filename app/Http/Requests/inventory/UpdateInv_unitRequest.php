<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Inv_unit;

class UpdateInv_unitRequest extends FormRequest
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
        $rules = Inv_unit::$rules_update;
        $rules['name'] = $rules['name'].",".$this->route("inv_unit");
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم وحده القياس',
            'name.min' => 'اسم وحده القياس  يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم وحده القياس يجب الا يزيد عن 50 حرف' ,
        ];
    }
}
