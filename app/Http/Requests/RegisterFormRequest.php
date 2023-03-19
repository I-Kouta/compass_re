<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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

    // $this->merge(['key' => $value])を実行すると任意のkeyとvalueの組み合わせをrules()に渡せる
    public function getValidatorInstance()
    {
        // プルダウンで選択された配列値を取得
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');
        // 日付を作成
        $datetime_validation = $old_year . '-' . $old_month . '-' . $old_day; // $datetimeを'-'で繋ぐ
        // rules()に渡す値を追加でセット、この場で変数にもバリデーションを設定できるようになる
        $this->merge([
            'datetime_validation' => $datetime_validation,
        ]);
        return parent::getValidatorInstance();
    }

    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'mail_address' => 'required|string|email|max:100|unique:users,mail_address',
            'sex' => 'required|string|between:1,3',
            'old_year' => 'required',
            'old_month' => 'required',
            'old_day' => 'required',
            'role' => 'required|string|between:1,4',
            'password' => 'required|string|min:8|max:30|confirmed',
            'datetime_validation' => 'date|before:today|after:1999-12-31',
        ];
    }

    public function messages(){
        return [
            'over_name.required' => '入力必須です',
            'over_name.string' => '形式が異なります',
            'over_name.max' => '最大10文字までです',
            'under_name.required' => '入力必須です',
            'under_name.string' => '形式が異なります',
            'under_name.max' => '最大10文字までです',
            'over_name_kana.required' => '入力必須です',
            'over_name_kana.string' => '形式が異なります',
            'over_name_kana.max' => '最大30文字までです',
            'over_name_kana.regex' => 'カタカナのみです',
            'under_name_kana.required' => '入力必須です',
            'under_name_kana.string' => '形式が異なります',
            'under_name_kana.max' => '最大30文字までです',
            'under_name_kana.regex' => 'カタカナのみです',
            'mail_address.required' => '入力必須です',
            'mail_address.string' => 'アドレス形式で入力してください',
            'mail_address.email' => 'アドレス形式で入力してください',
            'mail_address.unique' => '既に登録されているアドレスです',
            'mail_address.max' => '最大100文字までです',
            'sex.required' => '入力必須です',
            'sex.string' => '形式が異なります',
            'sex.between' => '無効な値です',
            'old_year.required' => '入力必須です',
            'old_month.required' => '入力必須です',
            'old_day.required' => '入力必須です',
            'role.required' => '入力必須です',
            'role.string' => '形式が異なります',
            'role.between' => '無効な値です',
            'password.required' => '入力必須です',
            'password.string' => '形式が異なります',
            'password.min' => '8文字以上入力してください',
            'password.max' => '最大30文字までです',
            'password.confirmed' => 'パスワードが一致しません',
            'datetime_validation.date' => '存在しない生年月日です',
            'datetime_validation.before' => '今日より前の生年月日を入力してください',
            'datetime_validation.after' => '2000年1月1日以降を入力してください',
        ];
    }
}
