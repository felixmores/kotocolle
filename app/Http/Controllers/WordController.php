<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use App\Models\Word;

class WordController extends Controller
{
    //認証確認
    public function __construct() {
        $this->middleware('auth');
    }
    
    //マイページ画面を表示
    public function mypage_index(Request $request) {
        $id = $request->user()->id;
        $my_words = Word::select('word', 'lank')->where('user_id', $id)->paginate(5);
        return view('mypage', ['my_words' => $my_words]);
    }

    //言葉登録画面を表示
    public function add_word_index(Request $request) {
        return view('add_word');
    }
}
