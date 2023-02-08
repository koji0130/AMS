<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    //バリデーション内容
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|min:2|max:12',
            'mail' => 'required|string|email:rfc,dns|min:5|max:40|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed|confirmed',
            /*'password-confirm' => 'required|string|min:8|max:20',*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    //新規登録
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'mail' => $data['mail'],
            'password' => bcrypt($data['password']),
        ]);
    }
    //auth認証
    public function redirectPath()
    {
        return '/index';
    }

    // public function registerForm(){
    //     return view("auth.register");
    // }

    //バリデーションの判断 新規登録
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            $validator = $this->validator($data); //バリデーションの呼び出し

            //もし、失敗したら
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            //入力に成功したら、新規登録できるよ
            $this->create($data); //createメソッドを呼び出し新規ユーザー登録
            $request->session()->put('username', $data['username']); //セッションの保存
            return redirect('added');
        }

        return view('auth.register');
    }



    public function added()
    {
        return view('auth.added');
    }
}
