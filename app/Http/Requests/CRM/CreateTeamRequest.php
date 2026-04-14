<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Team;

class CreateTeamRequest extends FormRequest
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
    //     return Team::$rules;
    // }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50|unique:teams'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم القسم',
            'name.min' => 'اسم القسم يجب الا يقل عن 2 احرف' ,
            'name.max' => 'اسم القسم يجب الا يزيد عن 50 حرف' ,
            'name.unique' => 'اسم القسم مكرر' ,

        ];
    }
}
