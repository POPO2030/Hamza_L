<?php

namespace App\Http\Requests\sales;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\sales\Invoice_return;

class CreateInvoice_returnRequest extends FormRequest
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
        return Invoice_return::$rules;
    }
}
