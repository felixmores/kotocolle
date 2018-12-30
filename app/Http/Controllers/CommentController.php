<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Comment;

class CommentController extends Controller
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
     * コメントの登録処理
     * バリデーション処理後に問題なければcommentsテーブルにレコード追加
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $user_id 言葉の作成者ID
     * @param int $word_id 言葉のID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment_add(Request $request, $user_id, $word_id) {
        $rules = [
            'comment' => 'required|max:150',
        ];
        $messages = [
            'comment.max' => 'コメントは150文字以内で入力してください。',
        ];
        $validator = Validator::make($request->only(['comment']), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $comment = new Comment;
            $comment->comment = $request->comment;
            $comment->user_id = $request->user()->id;
            $comment->word_id = $word_id;
            $comment->save();
            return back();
        }
    }

    /**
     * コメントの削除処理
     * (※ユーザー自身のコメントがある場合か管理者のみ削除ボタンを表示するため、
     * レコード存在チェックはなし)
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $user_id 言葉の作成者ID
     * @param int $word_id 言葉のID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment_delete(Request $request, $user_id, $word_id) {
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        return back();
    }
}
