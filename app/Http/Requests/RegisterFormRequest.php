<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // このリクエストの使用を認証する
    }

    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
            'mail_address' => 'required|email|max:100|unique:users,mail_address',
            'sex' => 'required',
            'old_year' => 'required',
            'old_month' => 'required',
            'old_day' => 'required',
            'date_of_birth' => 'date|after:1999-12-31|before:today',
            'password' => 'required|alpha_num|min:8|max:30|confirmed',
        ];
    }

    protected function prepareForValidation()
    {
        // 日時をデータに追加
        $date_of_birth = ($this->filled(['old_year','old_month','old_day'])) ? $this->old_year .'-'. $this->old_month .'-'. $this->old_day:'';
        $this->merge([
           'date_of_birth' => $date_of_birth
        ]);
    }

    public function messages()
    {
        return [
        'over_name.required' => '名字は必須です。',
        'under_name.required' => '名前は必須です。',
        'over_name_kana.required' => '名字（カナ）は必須です。',
        'under_name_kana.required' => '名前（カナ）は必須です。',
        'over_name_kana.regex' => '名字（カナ）はカタカナで入力してください。',
        'under_name_kana.regex' => '名前（カナ）はカタカナで入力してください。',
        'mail_address.required' => 'メールアドレスは必須です。',
        'mail_address.email' => '正しいメールアドレスの形式で入力してください。',
        'mail_address.unique' => 'そのメールアドレスは既に登録されています。',
        'mail_address.max' => 'メールアドレスは100文字以内で入力してください。',
        'sex' => '性別は必須です。',
        'old_year' => '年を入力してください。',
        'old_month' => '月を入力してください。',
        'old_day' => '日を入力してください。',
        'date_of_birth.date' => '正しい日付を入力してください。',
        'date_of_birth.after' => '生年月日は2000年1月1日以降の日付を入力してください。',
        'date_of_birth.before' => '生年月日は今日までの日付を入力してください。',
        'role' => '役職の選択は必須です。',
        'password.required' => 'パスワードは必須です。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.max' => 'パスワードは30文字以内で入力してください。',
        ];
    }

}
