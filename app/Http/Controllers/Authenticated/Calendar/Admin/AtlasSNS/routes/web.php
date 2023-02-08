<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();
//ログイン中ページ、auth認証ずみ、
Route::group(['middleware' => 'auth'], function () {  //ログイン認証しているページをくくる
  //サイドバー
  // Route::get('/login', 'FollowsController@followCounts'); //フォロー数
  //Route::get('/login', 'PostsController@followerCounts');フォロワー数

  //トップページ
  Route::get('/top', 'PostsController@index');  //トップページ
  Route::post('/post/create', 'PostsController@create'); //投稿用ルーティング
  Route::get('/post/update', 'PostsController@update'); //投稿の編集
  Route::get('/post/{id}/delete', 'PostsController@delete'); //投稿の削除


  //プロフィールページ
  Route::get('/profile', 'UsersController@profile');  //プロフィールページを表示
  Route::post('/profile/update', 'UsersController@store');  //プロフィールフォーム

  //検索ページ
  Route::post('/search', 'UsersController@search');  //検索ページ
  Route::get('/search', 'UsersController@search');  //検索ページ
  Route::get('/search/{id}/follow', 'FollowsController@follow')->name('follow');  //検索ページ フォロー機能
  Route::get('/search/{id}/unfollow', 'FollowsController@unfollow')->name('unfollow');  //検索ページ フォロー解除

  //フォローリスト
  Route::get('/follow-list', 'FollowsController@followlist');

  //フォロワーリスト
  Route::get('/follower-list', 'FollowsController@followerList');  //フォロワーページへ推移
});

//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login')->name('login');  //ログイン前ページ
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register');  //新規登録ページ
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');  //新規登録成功ページ
Route::post('/added', 'Auth\RegisterController@added');


//ログアウト機能
Route::get('/logout', 'Auth\LoginController@logout');  //ログアウト
