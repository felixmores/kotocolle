<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Word;
use App\Http\Requests\WordRequest;
use Illuminate\Support\Facades\DB;

class WordController extends Controller
{
    /**
     * 認証確認
     * 
     * @return void
     */
    public function __construct() {
        $this->middleware('auth')->except('share_word_index', 'word_content_index');
    }
    
    /**
     * マイページ画面を表示
     * 管理者アカウントでは言葉を使わないため、マイページ画面はなし
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @return \Illuminate\Http\Response
     */
    public function mypage_index(Request $request) {
        $admin_flag = $request->user()->admin_flag;
        if ($admin_flag === 1) {
            return redirect()->action('IndexController@index');
        } else {
            $id = $request->user()->id;
            $my_words = Word::select('id', 'word', 'user_id', 'lank')->where('user_id', $id)->orderBy('updated_at', 'desc')->paginate(5);
            return view('mypage', ['my_words' => $my_words]);
        }
    }

    /**
     * 言葉登録画面を表示
     * 管理者アカウントではマイページ画面に遷移しないため、言葉登録画面にも遷移しない
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @return \Illuminate\Http\Response
     */
    public function add_word_index(Request $request) {
        $admin_flag = $request->user()->admin_flag;
        if ($admin_flag === 1) {
            return redirect()->action('IndexController@index');
        } else {
            return view('add_word');
        }
    }

    /**
     * 言葉を新規登録
     * 未登録の言葉のみ、新規登録する
     * 
     * @param \App\Http\Requests\WordRequest $request
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse
     */
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
                $env_check = config('envswitch.env_flag');
                if ($env_check === 'heroku') {
                    $image_path = $request->word_image->store('word_images', 'heroku');
                } else {
                    $image_path = $request->word_image->store('word_images', 'public');
                }
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

    /**
     * 言葉の詳細画面を表示
     * 公開中、管理者、非公開かつ登録者本人のみアクセス可能。付随するコメントも表示。
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $user_id 言葉の作成者ID
     * @param int $word_id 言葉のID
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse
     */
    public function word_content_index(Request $request, $user_id, $word_id) {
        $word_content = Word::where('id', $word_id)->where('user_id', $user_id)->first();
        if ($word_content) {
            if (Auth::check()) {
                $admin_flag = $request->user()->admin_flag;
                $login_id = $request->user()->id;
            } else {
                /**
                 * 未ログインの場合、公開フラグを0、ログインユーザーのIDを0とする
                 * (ログイン時にはあり得ない値)
                 */
                $admin_flag = 0;
                $login_id = 0;
            }
                if (($login_id == $user_id && $word_content->share_flag == 0) || $word_content->share_flag == 1 || $admin_flag === 1) {
                    $word_image = $word_content->word_image;
                    $env_check = config('envswitch.env_flag');
                    if ($env_check === 'heroku') {
                        $word_image_exist = Storage::disk('heroku')->exists('word_images/'.$word_image);
                    } else {
                        $word_image_exist = Storage::disk('public')->exists('word_images/'.$word_image);
                    }
    
                    if ($word_image && $word_image_exist) {
                        $image_name = $word_image;
                    } else {
                        $image_name = 'no_word_image.jpg';
                    }
    
                    $comment_all = DB::table('comments')->select('comments.id', 'comment', 'user_id', 'comments.created_at', 'users.name')
                        ->where('word_id', $word_id)
                        ->join('users', function ($join) {
                            $join->on('comments.user_id', '=', 'users.id')
                                    ->whereNull('users.deleted_at');
                    })->get();
                    return view('word_content', ['word_content' => $word_content, 'image_name' => $image_name, 'admin_flag' => $admin_flag, 'login_id' => $login_id, 'comment_all' => $comment_all, 'env_check' => $env_check]);
                } else {
                    if (Auth::check()) {
                        return redirect()->action('WordController@mypage_index');
                    } else {
                        return redirect()->action('WordController@share_word_index');
                    }
                }
        } else {
            if (Auth::check()) {
                return redirect()->action('WordController@mypage_index');
            } else {
                return redirect()->action('WordController@share_word_index');
            }
        }
    }

    /**
     * 言葉を削除
     * レコード削除と共に画像も削除する
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $user_id 言葉の作成者ID
     * @param int $word_id 言葉のID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function word_delete(Request $request, $user_id, $word_id) {
        $word_content = Word::find($word_id);
        $word_image_name = $word_content->word_image;
        if ($word_image_name) {
            $env_check = config('envswitch.env_flag');
            if ($env_check === 'heroku') {
                Storage::disk('heroku')->delete('word_images/'.$word_image_name);
            } else {
                Storage::disk('public')->delete('word_images/'.$word_image_name);
            }
        }

        $word_content->delete();
        return redirect()->action('WordController@mypage_index');
    }

    /**
     * 言葉編集画面を表示
     * 編集は登録者本人のみ可能
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $user_id 言葉の作成者ID
     * @param int $word_id 言葉のID
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 言葉を更新
     * 更新後の言葉が登録済みの言葉と重複しないようにチェック。
     * 
     * @param \App\Http\Requests\WordRequest $request
     * @param int $user_id 言葉の作成者ID
     * @param int $word_id 言葉のID
     * @return \Illuminate\Http\RedirectResponse
     */
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
                    $env_check = config('envswitch.env_flag');
                    if ($env_check === 'heroku') {
                        Storage::disk('heroku')->delete('word_images/'.$old_image_name);
                    } else {
                        Storage::disk('public')->delete('word_images/'.$old_image_name);
                    }
                }
                $image_path = $request->word_image->store('word_images');
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

    /**
     * シェアした言葉の一覧画面を表示
     * 退会していないユーザーで公開中の言葉を表示する
     * 
     * @return \Illuminate\Http\Response
     */
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

    /**
     * 登録ユーザーの言葉一覧画面を表示(管理画面)
     * 管理者のみアクセス可能
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $user_id 各言葉の登録ユーザーのID
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse
     */
    public function words_list(Request $request, $user_id) {
        if ($request->user()->admin_flag === 1) {
            $words_list = Word::where('user_id', $user_id)->orderBy('id', 'asc')->paginate(5);
            return view('words_list', ['words_list' => $words_list]);
        } else {
            return redirect()->action('IndexController@index');
        }
    }
}
