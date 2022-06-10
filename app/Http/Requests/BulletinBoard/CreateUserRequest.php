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
            'under_nama' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max;30',
            'under_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max;30',
            'mail_address' => 'required|string|email|max:100|unique:users',
            'sex' => 'required',
            'birth_day' => 'required|date',
            'role' => 'required',
            'password' => 'required|string|min:8|max:30|confirmed',
            'password_confirmation' => 'required|string|min:8|max:30',

        ];
    }

    public function messages(){
        return [
            'over_name.required' => '名前は必須です。',
        ];
    }
}
