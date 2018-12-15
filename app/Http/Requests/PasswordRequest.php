<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
    public function rules()
    {
        return [
            'password' => 'required',
            'new_password' => 'required|confirmed|min:6|max:15|alpha_dash|',
            'new_password_confirmation' => 'required|min:6|max:15|alpha_dash|',
        ];
    }

    public function messages() {
        return [
            'new_password.min' => '新しいパスワードは6文字以上15文字以内です。',
            'new_password.max' => '新しいパスワードは6文字以上15文字以内です。',
            'new_password.alpha_dash' => '新しいパスワードは半角英数字とダッシュ(-)、下線(_)で作成してください。',
            'new_password.confirmed' => '新しいパスワードが確認パスワードと一致しません。',
            'new_password_confirmation.min' => '確認パスワードは6文字以上15文字以内です。',
            'new_password_confirmation.max' => '確認パスワードは6文字以上15文字以内です。',
            'new_password_confirmation.alpha_dash' => '確認パスワードは半角英数字とダッシュ(-)、下線(_)で作成してください。',
        ];
    }
}
