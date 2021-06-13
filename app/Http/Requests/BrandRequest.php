<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name' =>'required',
            'photo' =>'required|mimes:jpg,jpeg,png',

        ];
    }
    public function messages()
    {
        return [
            'name.required' =>'هذة القيمة مطلوبة',
            'photo.required' =>'هذة القيمة مطلوبة',
            'photo.mimes' => 'هذة القيمة يجب ان تكون من نوع صورة',

        ];
    }
}
