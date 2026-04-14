<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Color;

class CreateColorRequest extends FormRequest
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
        return Color::$rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم مجموعه الالوان',
            // 'name.unique' => 'اسم مجموعه الالوان مكرر' ,
        ];
    }
}
