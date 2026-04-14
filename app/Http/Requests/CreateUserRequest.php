<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class CreateUserRequest extends FormRequest
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
        return [
        'name' => 'required|min:2|max:50',
        'username' => 'required|min:2|max:20|unique:users',
        'team_id' => 'required',
        'role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'برجاء ادخال اسم كامل',
            'name.min' => 'يجب ان يكون الاسم  كامل اكبر من حرفين',
            'name.max' => 'يجب ان يكون الاسم كامل لا يزيد عن 50 حرف',
            'username.required' => 'برجاء ادخال اسم المسنخدم',
            'username.unique' => 'برجاء ادخال اسم المستخدم',
            'username.min' => 'يجب ان يكون اسم المستخدم اكبر من حرفين',
            'username.max' => 'يجب ان يكون اسم المستخدم لا يزيد عن 20 حرف',
            'team_id.required' => 'برجاء ادخال اسم القسم',
            'role_id.required' => 'برجاء ادخال اسم الصلاحيه',
        ];
    }
}
