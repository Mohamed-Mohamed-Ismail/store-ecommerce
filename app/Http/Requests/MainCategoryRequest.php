<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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
            'slug' => 'required|unique:categories,slug,' . $this->id,
            'type' => 'required|in:1,2'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'هذة القيمة مطلوبة',
            'type.required' => 'هذة القيمة مطلوبة',
            'type.in' => 'هذة القيمة غير صحيحة',
            'slug.required' => 'هذة القيمة مطلوبة',
            'slug.unique' => 'هذة القيمة موجودة بالفعل',

        ];
    }
}
