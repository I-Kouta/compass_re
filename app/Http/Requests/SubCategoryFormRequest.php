<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category' => 'required|max:100|string|unique:sub_categories',
        ];
    }

    public function messages()
    {
        return [
            'main_category_id.required' => 'メインカテゴリの入力は必須です。',
            'main_category_id.exists' => '存在しないメインカテゴリーが選択されています。',
            'sub_category.required' => 'サブカテゴリーの入力は必須です。',
            'sub_category.max' => '100文字以内で入力してください。',
            'sub_category.string' => '形式が異なります。',
            'sub_category.unique' => 'すでに存在しているカテゴリーです。',
        ];
    }
}
