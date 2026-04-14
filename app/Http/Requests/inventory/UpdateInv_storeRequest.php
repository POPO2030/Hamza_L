<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Inv_store;

class UpdateInv_storeRequest extends FormRequest
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
        $rules = Inv_store::$rules_update;
        $rules['name'] = $rules['name'].",".$this->route("inv_store");
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'عفوآ...يجب ادخال اسم المخزن',
        ];
    }
}
