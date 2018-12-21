<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Storage;
use App\Models\Word;
use App\Models\Comment;
use App\Http\Requests\WordRequest;
use Illuminate\Support\Facades\DB;

class WordController extends Controller
{
    //認証確認
    public function __construct() {
        $this->middleware('auth');
    }
    
    //マイページ画面を表示
    public function mypage_index(Request $request) {
        $id = $request->user()->id;
        $my_words = Word::select('id', 'word', 'user_id', 'lank')->where('user_id', $id)->orderBy('updated_at', 'desc')->paginate(5);
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

            if ($request->hasfile('word_image')) {
                $image_path = $request->word_image->store('public/word_images');
                $word->word_image = basename($image_path);
            } else {
                $word->word_image = null;
            }

            $word->share_flag = $request->share_radios;
            $word->save();
            $last_insert_id = $word->id;
            $last_insert_user_id = $word->user_id;
            return redirect()->action('WordController@word_content_index', ['user_id' => $last_insert_user_id, 'word_id' => $last_insert_id]);
        }
    }

    //言葉の詳細画面を表示
    public function word_content_index(Request $request, $user_id, $word_id) {
        $word_content = Word::where('id', $word_id)->where('user_id', $user_id)->first();
        if ($word_content) {
            if (($request->user()->id == $user_id && $word_content->share_flag == 0) || $word_content->share_flag == 1) {
                if ($word_content->word_image) {
                    $image_name = $word_content->word_image;
                } else {
                    $image_name = 'no_word_image.jpg';
                }
                $comment_all = Comment::where('word_id', $word_id)->get();
                return view('word_content', ['word_content' => $word_content, 'image_name' => $image_name, 'comment_all' => $comment_all]);
            }
        } else {
            return redirect()->action('WordController@mypage_index');
        }
    }

    //言葉を削除
    public function word_delete(Request $request, $user_id, $word_id) {
        $word_content = Word::find($word_id);
        $word_image_name = $word_content->word_image;
        if ($word_image_name) {
            Storage::delete('public/word_images/'.$word_image_name);
        }

        $word_content->delete();
        return redirect()->action('WordController@mypage_index');
    }

    //言葉編集画面を表示
    public function word_edit(Request $request, $user_id, $word_id) {
        $edit_content = Word::where('id', $word_id)->where('user_id', $user_id)->first();
        if ($request->user()->id == $user_id && $edit_content == true) {
            $select_texts = [
                                'ランクを選択してください',
                                '金言',
                                '銀言',
                                '銅言',
                            ];
            $selected = '';
            return view('edit_word', ['edit_content' => $edit_content, 'select_texts' => $select_texts, 'selected' => $selected]);
        } else {
            return redirect()->action('WordController@mypage_index');
        }
    }

    //言葉を更新
    public function word_update(WordRequest $request, $user_id, $word_id) {
        $input_word = $request->input('word');

        $same_word_num = Word::where('user_id', $user_id)->where('id', '!=', $word_id )
                        ->where('word', $input_word)->count('word');
        if ($same_word_num > 0) {
            return back()->withInput()->with('alert_msg', '以前に登録済みの言葉です。修正が必要ならば言葉詳細画面の「編集する」ボタンから修正してください。');
        } else {
            $word = Word::find($word_id);
            $word->word = $request->word;
            $word->lank = $request->lank;
            $word->memo = $request->memo;

            $old_image_name = $word->word_image;
            
            if ($request->hasfile('word_image')) {
                if ($old_image_name) {
                    Storage::delete('public/word_images/'.$old_image_name);
                }
                $image_path = $request->word_image->store('public/word_images');
                $word->word_image = basename($image_path);
            } elseif ($old_image_name) {
                $word->word_image = $old_image_name;
            } else {
                $word->word_image = null;
            }

            $word->share_flag = $request->share_radios;
            $word->save();
            $update_word_id = $word->id;
            $update_user_id = $word->user_id;
            return redirect()->action('WordController@word_content_index', ['user_id' => $update_user_id, 'word_id' => $update_word_id]);
        }
    }

    //シェアした言葉の一覧画面を表示
    public function share_word_index() {
        $share_words = DB::table('words')->select('words.id', 'user_id', 'word', 'name', 'lank')
                        ->join('users', function ($join) {
                            $join->on('words.user_id', '=', 'users.id')
                                    ->where('words.share_flag', 1)
                                    ->whereNull('users.deleted_at');
                        })
                        ->orderBy('words.updated_at', 'desc')->paginate(5);
        return view('sharewords', ['share_words' => $share_words]);
    }

    //言葉の一覧画面を表示
    /*
    public function words_list(Request $request) {
        if ($request->user()->admin_flag) {
            $words_list = Word::where()
        }
    }
    */
}
