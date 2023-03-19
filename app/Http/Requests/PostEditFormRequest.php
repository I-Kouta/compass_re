<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostEditFormRequest extends FormRequest
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
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ];
    }

    public function messages(){
        return [
            'post_title.required' => 'タイトルの入力は必須です。',
            'post_title.string' => '形式が異なります。',
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.required' => '内容の入力は必須です。',
            'post_body.string' => '形式が異なります。',
            'post_body.max' => '投稿内容は5000文字以内で入力してください。',
        ];
    }
}
