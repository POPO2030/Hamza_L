<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\ServiceItem;

class UpdateServiceItemRequest extends FormRequest
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
    //     $rules_update = ServiceItem::$rules_update;
        
    //     return $rules_update;
    // }
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
            // 'price' => 'required|min:1|max:20',
            'service_id' => 'required',
            'stage_id' => 'required|array',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'برجاء ادخال اسم العنصر',
            'name.min' => 'يجب ان يكون الاسم اكبر من حرفين',
            'name.max' => 'يجب ان يكون الاسم لا يزيد عن 50 حرف',
            // 'price.required' => 'برجاء ادخال السعر ',
            'service_id.required' => 'برجاء ادخال اسم المجموعه',
            'stage_id.required' => 'برجاء ادخال مرحله انتاج واحده على الاقل',
        ];
    }
}
