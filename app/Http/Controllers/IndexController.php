<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class IndexController extends Controller
{
    //LPの表示
    public function index() {
        if (Auth::check()) {
            $admin_flag = User::where('id', Auth::id())->value('admin_flag');
            if ($admin_flag == 1) {
                return redirect()->action('UserController@users_list_index');
            } else {
                return redirect()->action('WordController@mypage_index');
            }
        } else {
            return view('index');
        }
    }
}
