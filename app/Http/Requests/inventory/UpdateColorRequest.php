<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Color;

class UpdateColorRequest extends FormRequest
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
    //     $rules_uppdate = Color::$rules_uppdate;
    //     $rules_uppdate['name'] = $rules_uppdate['name'].",".$this->route("color");
    //     return $rules_uppdate;
    // }
    public function rules()
    {
        $rules_uppdate = Color::$rules_uppdate;
        
        return $rules_uppdate;
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم اللون'
        ];
    }
}
