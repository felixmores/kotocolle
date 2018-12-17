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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

//LP表示
Route::get('/', 'IndexController@index');
Auth::routes();

//マイページ表示
Route::get('/mypage', 'WordController@mypage_index');

//言葉登録画面を表示
Route::get('/mypage/add_word', 'WordController@add_word_index');
//言葉を新規登録
Route::post('/mypage/add_word', 'WordController@add_word_new');

//言葉の詳細画面を表示
Route::get('/word_content/{user_id}/{word_id}', 'WordController@word_content_index');
//言葉を削除する
Route::post('/word_content/{user_id}/{word_id}', 'WordController@word_delete');
//言葉の編集画面を表示
Route::get('/word_content/{user_id}/{word_id}/edit_word', 'WordController@word_edit');
//言葉を更新する
Route::post('/word_content/{user_id}/{word_id}/edit_word', 'WordController@word_update');

//ユーザー情報を表示
Route::get('/userinfo', 'UserController@userinfo_index');
//ユーザー情報の編集画面を表示
Route::get('/userinfo/edit', 'UserController@userinfo_edit');
//ユーザー情報を更新する
Route::post('/userinfo/edit', 'UserController@userinfo_update');
//パスワード変更画面を表示
Route::get('/userinfo/password_edit', 'UserController@password_edit');
//パスワードを更新する
Route::post('/userinfo/password_edit', 'UserController@password_update');
//ユーザーの退会処理
Route::post('/userinfo', 'UserController@userinfo_delete');

//シェアした言葉の一覧画面を表示
Route::get('/shareword', 'WordController@share_word_index');

//Route::get('/home', 'HomeController@index')->name('home');
