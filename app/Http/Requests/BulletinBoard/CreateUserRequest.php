<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'mail_address' => 'required|string|email|max:100|unique:users',
            'sex' => 'required',
            'old_year' => 'required_with:old_month,old_day|after:1999',
            'old_month' => 'required_with:old_year,old_day',
            'old_day' => 'required_with:old_year,old_month',
            'password' => 'required|string|min:8|max:30|confirmed',
            'password_confirmation' => 'required|string|min:8|max:30',

        ];
    }

    public function messages(){
        return [
            'over_name.required' => '性は必須です。',
            'over_name.string' => '正しい形式で入力してください。',
            'over_name.max' => '姓は10文字以内で入力してください。',
            'under_name.required' => '名は必須です。',
            'under_name.string' => '正しい形式で入力してください。',
            'under_name.max' => '名は10文字以内で入力してください。',
            'over_name_kana.required' => 'セイは必須です。',
            'over_name_kana.string' => '正しい形式で入力してください。',
            'over_name_kana.regex' => 'カタカナで入力してください。',
            'over_name_kana.max' => 'セイは30文字以内で入力してください。',
            'under_name_kana.required' => 'メイは必須です。',
            'under_name_kana.string' => '正しい形式で入力してください。',
            'under_name_kana.regex' => 'カタカナで入力してください。',
            'under_name_kana.max' => 'メイは30文字以内で入力してください。',
            'mail_address.required' => 'メールアドレスは必須です。',
            'mail_address.string' => '正しい形式で入力してください。',
            'mail_address.email' => '正しいメールアドレスの形式で入力してください。',
            'mail_address.unique' => '既に登録されているメールアドレスです。',
            'sex.required' => '選択必須です。',
            'old_year.required_with' => '生年月日（年）は必須です。',
            'old_year.after' => '2000年1月1日以降で入力してください。',
            'old_month.required_with' => '生年月日（月）は必須です。',
            'old_day.required_with' => '生年月日（日）は必須です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以内で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
            'password_confirmation.min' => 'パスワードは8文字以上で入力してください。',
            'password_confirmation.max' => 'パスワードは30文字以内で入力してください。',
        ];
    }
}
