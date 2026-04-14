<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Size;

class CreateSizeRequest extends FormRequest
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
        return Size::$rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'عفوآ...يجب ادخال المقاس',
            'name.max' => 'عفوآ...يجب اسم المقاس عن 50 حرف',
            'name.unique' => 'عفوآ...اسم المقاس موجود من قبل' ,
    
        ];
    }
}
