<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\suppliers;

class CreatesuppliersRequest extends FormRequest
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
        return suppliers::$rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال الاسم',
            'name.min' => 'اسم المورد يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم المورد يجب الا يزيد عن 50 حرف' ,
            'name.unique' => 'اسم المورد مكرر' ,
        ];
    }
}
