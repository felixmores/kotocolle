<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use App\Models\Word;
use App\Http\Requests\WordRequest;

class WordController extends Controller
{
    //認証確認
    public function __construct() {
        $this->middleware('auth');
    }
    
    //マイページ画面を表示
    public function mypage_index(Request $request) {
        $id = $request->user()->id;
        $my_words = Word::select('id', 'word', 'lank')->where('user_id', $id)->orderBy('updated_at', 'desc')->paginate(5);
        return view('mypage', ['my_words' => $my_words]);
    }

    //言葉登録画面を表示
    public function add_word_index(Request $request) {
        return view('add_word');
    }

    //言葉を新規登録
    public function add_word_new(WordRequest $request) {
        
        $input_word = $request->input('word');
        $login_id = $request->user()->id;

        $same_word_num = Word::where('user_id', $login_id)
                        ->where('word', $input_word)->count('word');
        if ($same_word_num > 0) {
            $alert_msg = '以前に登録済みの言葉です。修正が必要ならば言葉詳細画面の「編集する」ボタンから修正してください。';
            return view('add_word',compact('alert_msg'));
        } else {
            $word = new Word;
            $word->word = $request->word;
            $word->user_id = $request->user()->id;
            $word->lank = $request->lank;
            $word->memo = $request->memo;

            if ($request->file('word_image')->isValid()) {
                $image_path = $request->word_image->store('public/word_images');
                $word->word_image = basename($image_path);
            } else {
                $word->word_image = null;
            }

            $word->share_flag = $request->share_radios;
            $word->save();
            return redirect('/mypage');
        }
    }

    //言葉の詳細画面を表示
    public function word_content_index(Request $request, $id) {
        return view('word_content');
    }
}
