<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralProductRequest extends FormRequest
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
            'name' => 'required|max:100',
            'slug' => 'required|unique:products,slug',
            'description'=>'required|max:1000',
            'short_description'=>'nullable|max:500',
            'categories'=>'array|min:1',
            'categories.*'=> 'numeric|exists:categories,id',
            'brand_id'=>'required|exists:brands,id',
            'tags'=>'nullable',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'هذة القيمة مطلوبة',
            'name.max' => 'أكثر عدد ممكن من الاحرف هو 100 حرف',
            'description.required' => 'هذة القيمة مطلوبة',
            'description.max' => 'أكثر عدد ممكن من الاحرف هو 1000 حرف',
            'short_description.max' => ' أكثر عدد ممكن من الاحرف هو 500 حرف',
            'categories.min' => 'يجب ان تختار قسم واحد على الاقل',
            'brands.required' => 'يجب ان تختار ماركة  واحدة على الاقل',
            'slug.required' => 'هذة القيمة مطلوبة',
            'slug.unique' => 'هذة القيمة موجودة بالفعل',

        ];
    }
}
