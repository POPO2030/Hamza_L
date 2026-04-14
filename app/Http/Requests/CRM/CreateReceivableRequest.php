<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Receivable;

class CreateReceivableRequest extends FormRequest
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
        return Receivable::$rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم المستلم',
            'name.unique' => ' اسم المستلم مكرر',
            'name.min' => 'يجب ان لا يقل اسم المستلم عن 2 حرف.',
            'name.max' => 'يجب ان لا يزيد اسم المستلم عن 50 حرف.',
            // 'phone.required' => 'يجب ادخال رقم التليفون',
            // 'phone.min' => 'رقم التليفون يجب الا يقل عن 7 احرف' ,
            // 'phone.max' => 'رقم التليفون يجب الا يزيد عن 12 حرف' ,
        ];
    }
}
