<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; ////Auth認証に必要な記述
use App\Post; //Postモデルを使用
use App\User; //Userモデルを使用

class FollowsController extends Controller
{
    //auth認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    //search.blade フォロー機能
    public function follow($id)
    {
        $following = Auth::user()->id; //$followingにログインユーザーidを代入
        $request = request('id');
        \DB::table('follows')->insert([ //followsテーブルに追加
            'following_id' => $following, //followind_idカラム$followingを持ってくる
            'followed_id' => $id,  //followed_idカラムに$followerを持ってくる
        ]);
        return redirect('search');  //search画面へルーティング
    }

    //search.blade フォロー解除機能
    public function unfollow($id)
    {
        \DB::table('follows')->where([ //followsテーブルを指定
            'followed_id' => $id, //followed_idカラムのフォローされてるID
            'following_id' => Auth::user()->id //following_idのログインユーザーのIDを
        ])
            ->delete(); //消す
        return redirect('search'); //search画面へルーティング
    }

    //follow.balde アイコンリスト、投稿リストの表示
    public function followlist()
    {
        // dd("123");
        // followsテーブルのレコードを取得
        $following_id = Auth::user()->follows()->pluck('followed_id'); // フォローしているユーザーのidを取得
        //dd($following_id);
        $following_users = User::orderBy('updated_at', 'desc')->whereIn('id', $following_id)->get(); //userテーブルuser_idとフォローしているユーザーidが一致している投稿を取得
        $posts = Post::orderBy('updated_at', 'desc')->with('user')->whereIn('user_id', $following_id)->get(); //Postテーブルuser_idとフォローしているユーザーidが一致している投稿を取得
        return view('follows.followList', compact('following_users', 'posts'));
    }

    //follower.balde アイコンリスト、投稿リストの表示
    public function followerList()
    {
        // dd("123");
        // followsテーブルのレコードを取得
        $followed_id = Auth::user()->followers()->pluck('following_id'); // フォローされているユーザーのidを取得
        //dd($following_id);
        $followed_users = User::orderBy('updated_at', 'desc')->whereIn('id', $followed_id)->get(); //userテーブルuser_idとフォローしているユーザーidが一致している投稿を取得
        $posts = Post::orderBy('updated_at', 'desc')->with('user')->whereIn('user_id', $followed_id)->get(); // フォローされているユーザーのidを元に投稿内容を取得
        return view('follows.followerList', compact('followed_users', 'posts'));
    }
}
