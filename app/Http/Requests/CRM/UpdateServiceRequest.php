<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Service;

class UpdateServiceRequest extends FormRequest
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
    //     $rules_update = Service::$rules_update;
        
    //     return $rules_update;
    // }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
            'service_category_id' => 'required',

        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'برجاء ادخال اسم الخدمه',
            'name.min' => 'يجب ان يكون الاسم اكبر من حرفين',
            'name.max' => 'يجب ان يكون الاسم لا يزيد عن 50 حرف',
            'service_category_id.required' => 'برجاء ادخال اسم المجموعه',

        ];
    }
}
