<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Color_category;

class UpdateColor_categoryRequest extends FormRequest
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
        $rules = Color_category::$rules_updates;
        
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم مجموعه الالوان',
        ];
    }
}

