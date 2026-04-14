<?php

namespace App\Http\Requests\sales;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\sales\Treasury;

class CreateTreasuryRequest extends FormRequest
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
        return Treasury::$rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال الاسم',
            'name.min' => 'اسم الخزينة يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم الخزينة يجب الا يزيد عن 50 حرف' ,
            'name.unique' => 'اسم الخزينة مكرر' ,
        ];
    }
}
