<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Customer;

class CreateCustomerRequest extends FormRequest
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
    // public function rules()
    // {
    //     return Customer::$rules;
    // }
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50|unique:customers',
            'phone' => 'required|min:7|max:12|unique:customers',
            // 'mobile' => 'required|min:7|max:12|unique:customers',
            // 'address' => 'required',
            // 'email' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال الاسم',
            'name.min' => 'اسم العميل يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم العميل يجب الا يزيد عن 50 حرف' ,
            'name.unique' => 'اسم العميل مكرر' ,
            'phone.required' => 'يجب ادخال رقم التليفون',
            'phone.min' => 'رقم التليفون يجب الا يقل عن 7 احرف' ,
            'phone.max' => 'رقم التليفون يجب الا يزيد عن 12 حرف' ,
            'phone.unique' => 'رقم التليفون مكرر' ,
            // 'mobile.required' => 'يجب ادخال رقم المحمول',
            // 'mobile.min' => 'رقم المحمول يجب الا يقل عن 2 احرف' ,
            // 'mobile.max' => 'رقم المحمول يجب الا يزيد عن 50 حرف' ,
            // 'mobile.unique' => 'رقم المحمول مكرر' ,

        ];
    }
}
