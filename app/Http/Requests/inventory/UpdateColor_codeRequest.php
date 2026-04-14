<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Color_code;

class UpdateColor_codeRequest extends FormRequest
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
        $rules = Color_code::$rules_updates;
        
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم كود اللون',
        ];
    }
}
