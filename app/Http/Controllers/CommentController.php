<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Comment;

class CommentController extends Controller
{
    //認証確認
    public function __construct() {
        $this->middleware('auth');
    }

    //コメントを登録する
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

    //コメントを削除する
    public function comment_delete(Request $request, $user_id, $word_id) {
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        return back();
    }
}
