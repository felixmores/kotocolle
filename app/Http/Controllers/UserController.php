<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
//use Illuminate\Support\Facades\Storage;
use App\Models\User;
//use App\Http\Requests\UserRequest;

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
}
