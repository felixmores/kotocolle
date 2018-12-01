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

Route::get('/home', 'HomeController@index')->name('home');
