<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' .$this->id,
            'password'=>'nullable|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'هذة القيمة مطلوبة',
            'email.required' => 'هذة القيمة مطلوبة',
            'email.email' => 'هذة القيمة يجب أن تكون صيغة بريد الكتروني',
            'email.unique' => 'هذة القيمة موجودة بالفعل',
            'password.confirmed' => 'كلمةالمرور الجديدة غير متطابقة',
            'password.min' => 'كلمةالمرور الجديدة يجب أن تكون على الاقل 8 ارقام'

        ];
    }
}
