<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 認証確認
     * 
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * ユーザー情報画面を表示
     * ユーザー画像の登録有無によって画像名を設定して表示
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function userinfo_index(Request $request) {
        $login_user_image = $request->user()->user_image;
        $env_check = config('envswitch.env_production');
        if ($env_check === 'pro') {
            $user_image_exist = false;
        } else {
            $user_image_exist = Storage::disk('public')->exists('user_images/'.$login_user_image);
        }

        if ($login_user_image && $user_image_exist) {
            $image_name = $login_user_image;
        } else {
            $image_name = 'no_user_image.gif';
        }
        return view('userinfo_index', ['name' => $request->user()->name, 'email' => $request->user()->email, 'image_name' => $image_name]);
    }

    /**
     * ユーザー情報編集画面を表示
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function userinfo_edit(Request $request) {
        $user_params = [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
        ];
        return view('userinfo_edit', $user_params);
    }

    /**
     * ユーザー情報を更新
     * 更新前にユーザー画像があれば削除してから更新
     * 
     * @param \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userinfo_update(UserRequest $request) {
        $user = User::find($request->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;

        $old_image_name = $user->user_image;
            
        if ($request->hasfile('user_image')) {
            if ($old_image_name) {
                Storage::delete('user_images/'.$old_image_name);
            }
            $image_path = $request->user_image->store('user_images');
            $user->user_image = basename($image_path);
        } elseif ($old_image_name) {
            $user->user_image = $old_image_name;
        } else {
            $user->user_image = null;
        }
        
        $user->save();
        return redirect()->action('UserController@userinfo_index');
    }

    /**
     * パスワード変更画面を表示
     * 
     * @return \Illuminate\Http\Response
     */
    public function password_edit() {
        return view('password_edit');
    }

    /**
     * パスワードを変更
     * 入力パスワードとハッシュ化したパスワードを照合して
     * 合致すれば、新しいパスワードをハッシュ化して更新する
     * 
     * @param \App\Http\Requests\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password_update(PasswordRequest $request) {
        $password = User::find($request->user()->id);
        $hashed_password = Hash::make($request->password);

        if (Hash::check($request->password, $hashed_password)) {
            $password->password = Hash::make($request->new_password);
            $password->save();
            return redirect()->action('UserController@userinfo_index');
        } else {
            return redirect()->action('UserController@password_edit');
        }
    }

    /**
     * ユーザー退会処理
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userinfo_delete(Request $request) {
        $user = User::find($request->user()->id);
        $user->delete();
        Auth::logout();
        return redirect()->action('IndexController@index');
    }

    /**
     * 登録ユーザー一覧表示(管理画面)
     * 管理者権限をチェックして、退会済みユーザーも含めて一覧表示
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse
     */
    public function users_list_index(Request $request) {
        if ($request->user()->admin_flag === 1) {
            $users_list = User::withTrashed()->orderBy('id', 'asc')->paginate(5);
            return view('users_list', ['users_list' => $users_list]);
        } else {
            return redirect()->action('IndexController@index');
        }
    }

    /**
     * 登録ユーザー強制退会(管理画面)
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function users_list_delete(Request $request) {
        $user = User::find($request->user_id);
        $user->delete();
        return back();
    }
}
