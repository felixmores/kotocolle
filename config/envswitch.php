<?php

return [
    /**
     * 環境変数FILESYSTEM_DRIVERの値をenv_flagとしてセットする
     * （ユーザー画像と言葉の画像の表示処理を切り替えるため）
     */
    'env_flag' => env('FILESYSTEM_DRIVER', 'heroku'),
];