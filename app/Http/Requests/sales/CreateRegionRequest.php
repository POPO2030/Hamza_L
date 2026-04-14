<?php

namespace App\Http\Requests\sales;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\sales\Region;

class CreateRegionRequest extends FormRequest
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
        return Region::$rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال الاسم',
            'name.min' => 'اسم المنطقه يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم المنطقه يجب الا يزيد عن 50 حرف' ,
            'name.unique' => 'اسم المنطقه مكرر' ,
 
        ];
    }
}
