<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator; //バリデーショん
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //Auth認証に必要な記述
use Illuminate\Support\Facades\Hash; //passwordのハッシュ化

class UsersController extends Controller
{
    //
    public function profile()
    {
        $user = Auth::user(); //ログイン認証しているユーザーデータの取得
        return view('users.profile');
    }

    //検索機能
    public function search(Request $request)
    {
        //dd("123");
        $user = Auth::user(); //ログイン認証しているユーザーデータの取得
        //$followlist = \DB::table('follows')
        //   ->where('following_id', '=', Auth::user()->id)
        //  ->get();
        $keyword = $request->input('keyword'); //入力した検索ワードを取得
        $query = \DB::table('users'); //usersテーブルを取得
        if (!empty($keyword)) {  //もしキーワードがあったら
            $query->where('username', 'LIKE', "%{$keyword}%") //カラムからキーワードを取得
                ->where('id', '!=', Auth::user()->id);  //自分を除く
        } else {
            $query
                ->where('id', '!=', Auth::user()->id); //自分を除く
        };
        $users = $query->get();  //メソッドを代入
        return view('users.search', ['keyword' => $keyword, 'users' => $users]);  //検索ワード、ユーザーを表示させる（bladeへ渡す）
    }

    //プロフィール バリデーションの内容
    //protected function validator(array $data)
    //{
    //  return Validator::make($data, [
    //     'username' => 'required|string|min:2|max:12',
    //       'mail' => 'required|string|email:rfc,dns|min:5|max:40|unique:users',
    //       'password' => 'required|string|min:8|max:20|confirmed|confirmed',
    //         'bio' => 'string|max:150',
    //        'images' => 'file|mines:jpg,png,bmp,gif,svg',
    //    ]);
    //}

    //プロフィール 編集機能
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:2|max:12',
            'mail' => 'required|string|email:rfc,dns|min:5|max:40|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed|confirmed',
            'bio' => 'string|max:150',
            'images' => 'file|mines:jpg,png,bmp,gif,svg',
        ]);

        //dd("123");
        $id = Auth::id();
        $username = $request->input('username');
        $mail = $request->input('mail');
        $password = $request->input('password');
        $bio = $request->input('bio');

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        } else {
            $filename = $request->imgpath->getClientOriginalName(); //画像のオリジナルネームを取得
            $img = $request->imgpath->storeAs('', $filename, 'public'); //画像を保存して、そのパスを$imgに保存。第三引数に'public'を指定
        }
        //dd($img);
        $validator->validate();
        \DB::table('users')
            ->where('id', $id)
            ->update(
                [
                    'username' => $username,
                    'mail' => $mail,
                    'password' => Hash::make($password),
                    'bio' => $bio,
                    'images' => $img
                ]
            );
        return redirect('top');  //トップページへリダイレクト（URL）
    }
}
