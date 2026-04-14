<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Weight;

class CreateWeightRequest extends FormRequest
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
        return Weight::$rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'عفوآ...يجب ادخال السمك',
            'name.max' => 'عفوآ...يجب اسم السمك عن 50 حرف',
            'name.unique' => 'عفوآ...اسم السمك موجود من قبل' ,
        ];
    }
}
