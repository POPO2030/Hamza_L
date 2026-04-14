<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Brand;

class CreateBrandRequest extends FormRequest
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
        return Brand::$rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'عفوآ...يجب ادخال اسم الماركه',
            'name.unique' => 'عفوآ...اسم الماركه موجود من قبل' ,
        ];
    }
}
