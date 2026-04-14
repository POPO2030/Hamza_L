<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Service;

class CreateServiceRequest extends FormRequest
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
    //     return Service::$rules;
    // }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50|unique:services',
            'service_category_id' => 'required',

        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'برجاء ادخال اسم الخدمه',
            'name.min' => 'يجب ان يكون الاسم اكبر من حرفين',
            'name.max' => 'يجب ان يكون الاسم لا يزيد عن 50 حرف',
            'name.unique' => 'عفوآ...اسم الخدمه موجود من قبل برجاء ادخال اسم جديد',
            'service_category_id.required' => 'برجاء ادخال اسم المجموعه',
           

        ];
    }
}
