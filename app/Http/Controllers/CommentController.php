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
    public function comment_add(Request $request) {
        $rules = [
            'comment' => 'required|max:150',
        ];
        $messages = [
            'comment.max' => 'コメントは150文字以内で入力してください。',
        ];
        $validator = Validator::make($request->comment, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $comment = new Comment;
            $comment->comment = $request->comment;
            $comment->user_id = $request->user()->id;
            $comment->word_id = $request->word_id;
            $comment->save();
            return back();
        }
    }
}
