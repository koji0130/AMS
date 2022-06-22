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
            'under_nama' => 'string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'mail_address' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|max:30|confirmed',
            'password_confirmation' => 'required|string|min:8|max:30',

        ];
    }

    public function messages(){
        return [
            'over_name.max' => '姓は10文字以内で入力してください。',
            'under_name.max' => '名は10文字以内で入力してください。',
            'over_name_kana.regex' => 'カタカナで入力してください。',
            'over_name_kana.max' => 'セイは30文字以内で入力してください。',
            'under_name_kana.regex' => 'カタカナで入力してください。',
            'under_name_kana.max' => 'メイは30文字以内で入力してください。',
            'mail_address.email' => '正しいメールアドレスの形式で入力してください。',
            'mail_address.unique' => '既に登録されているメールアドレスです。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以内で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
            'password_confirmation.min' => 'パスワードは8文字以上で入力してください。',
            'password_confirmation.max' => 'パスワードは30文字以内で入力してください。',
        ];
    }
}
