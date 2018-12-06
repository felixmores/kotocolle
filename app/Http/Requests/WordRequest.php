<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WordRequest extends FormRequest
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
            'word' => "required|max:30",
            'word_image' => 'nullable|image|mimes:jpeg,jpg|max:500|dimensions:max_width=500,max_height=500',
            'memo' => 'max:150',
        ];
    }

    public function messages() {
        return [
            'word.max' => '言葉は30文字までです。',
            'word_image.image' => 'ファイルは画像を選択してください。',
            'word_image.mimes' => '画像はJPEGファイルのものを選択してください。',
            'word_image.max' => 'ファイルサイズは500KBまでです。',
            'word_image.dimensions' => '画像の大きさは幅500px、高さ500pxまでです。',
            'memo.max' => 'メモは150文字までです。',
        ];
    }
}
