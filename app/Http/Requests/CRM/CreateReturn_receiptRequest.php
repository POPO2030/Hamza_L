<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Return_receipt;

class CreateReturn_receiptRequest extends FormRequest
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
    //     return Return_receipt::$rules;
    // }

    public function rules()
    {
        return [
            // 'model' => 'min:2|max:50',
            // 'initial_count' => 'required',
            'product_id' => 'required',
            'img[]' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            // 'model.min' => 'رقم الموديل يجب الا يقل عن 2 احرف',
            // 'model.max' => 'رقم الموديل يجب الا يزيد عن 50 حرف',
            // 'initial_count.required' => 'العدد المبدئى مطلوب',
            'product_id.required' => 'يجب اختيار اسم الصنف',
            'img.image' => 'الملف المختار يجب ان يكون صورة',
            'img.mimes' => 'الصورة المختارة يجب ان تكون صيغتها JPEG, PNG, JPG .',
            'img.max' => 'يجب الاتزيد مساحت الصورة عن 2 ميجابايت'
        ];
    }
}
