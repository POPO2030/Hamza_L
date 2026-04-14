<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\final_product;

class Updatefinal_productRequest extends FormRequest
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
        $rules = final_product::$rules_update;
        $rules['name'] = $rules['name'].",".$this->route("final_product");
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم الصنف',
        ];
    }
}
