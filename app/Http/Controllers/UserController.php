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
    //認証確認
    public function __construct() {
        $this->middleware('auth');
    }

    //ユーザー情報画面を表示
    public function userinfo_index(Request $request) {
        if ($request->user()->user_image) {
            $image_name = $request->user()->user_image;
        } else {
            $image_name = 'no_user_image.gif';
        }
        return view('userinfo_index', ['name' => $request->user()->name, 'email' => $request->user()->email, 'image_name' => $image_name]);
    }

    //ユーザー情報編集画面を表示
    public function userinfo_edit(Request $request) {
        $user_params = [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
        ];
        return view('userinfo_edit', $user_params);
    }

    //ユーザー情報を更新
    public function userinfo_update(UserRequest $request) {
        $user = User::find($request->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;

        $old_image_name = $user->user_image;
            
        if ($request->hasfile('user_image')) {
            if ($old_image_name) {
                Storage::delete('public/user_images/'.$old_image_name);
            }
            $image_path = $request->user_image->store('public/user_images');
            $user->user_image = basename($image_path);
        } elseif ($old_image_name) {
            $user->user_image = $old_image_name;
        } else {
            $user->user_image = null;
        }
        
        $user->save();
        return redirect()->action('UserController@userinfo_index');
    }

    //パスワード変更画面を表示
    public function password_edit() {
        return view('password_edit');
    }

    //パスワードを変更
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

    //ユーザー退会処理
    public function userinfo_delete(Request $request) {
        $user = User::find($request->user()->id);
        $user->delete();
        Auth::logout();
        return redirect()->action('IndexController@index');
    }

    //登録ユーザー一覧表示
    public function users_list_index() {
        $users_list = User::withTrashed()->orderBy('id', 'asc')->paginate(5);
        return view('users_list', ['users_list' => $users_list]);
    }

    //登録ユーザー強制退会
    public function users_list_delete(Request $request) {
        $user = User::find($request->user_id);
        $user->delete();
        return back();
    }
}
