<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //LPの表示
    public function index() {
        if (Auth::check()) {
            return redirect()->action('WordController@index');
        } else {
            return view('index');
        }
    }
}
