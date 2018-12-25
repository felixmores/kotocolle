<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $user_id = $request->user()->id;
        return [
            'name' => 'required|max:20',
            'email' => "required|email|unique:users,email,{$user_id}|max:50",
            'user_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:500|dimensions:max_width=200,max_height=200',
        ];
    }

    /**
     * バリデーションメッセージ
     * 
     * @return array
     */
    public function messages() {
        return [
            'name.max' => 'ユーザー名は20文字までです。',
            'email.max' => 'メールアドレスは50文字までです。',
            'user_image.image' => 'ファイルは画像を選択してください。',
            'user_image.mimes' => '画像はJPEG、PNG、GIFファイルのものを選択してください。',
            'user_image.max' => 'ファイルサイズは500KBまでです。',
            'user_image.dimensions' => '画像の大きさは幅200px、高さ200pxまでです。',
        ];
    }
}
