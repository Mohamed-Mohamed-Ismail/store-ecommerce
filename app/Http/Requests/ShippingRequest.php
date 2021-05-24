<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'id' =>'required|exists:settings',
            'value' =>'required',
            'plain_value' =>'nullable|numeric'
        ];
    }
    public function messages()
    {
        return [
            'id.exists' =>'هذة القيمة غير موجودة',
            'id.required' =>'هذة القيمة مطلوبة',
            'value.required' =>'هذة القيمة مطلوبة',
            'plain_value.numeric' =>'هذة القيمة يجب أن تكون رقم'

        ];
    }
}
