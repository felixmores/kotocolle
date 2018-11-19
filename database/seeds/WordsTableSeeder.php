<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('words')->insert([
            //user_id = 1のダミーレコード10行
            ['word' => '犬も歩けば棒に当たる','user_id' => 1,'lank' => 1],
            ['word' => '当たるも八卦当たらぬも八卦','user_id' => 1,'lank' => 2],
            ['word' => '人間万事塞翁が馬','user_id' => 1,'lank' => 3],
            ['word' => '触らぬ神に祟りなし','user_id' => 1,'lank' => 1],
            ['word' => '虎穴に入らずんば虎子を得ず','user_id' => 1,'lank' => 2],
            ['word' => '犬も歩けば棒に当たる','user_id' => 1,'lank' => 1],
            ['word' => '当たるも八卦当たらぬも八卦','user_id' => 1,'lank' => 2],
            ['word' => '人間万事塞翁が馬','user_id' => 1,'lank' => 3],
            ['word' => '触らぬ神に祟りなし','user_id' => 1,'lank' => 1],
            ['word' => '虎穴に入らずんば虎子を得ず','user_id' => 1,'lank' => 2],
            //user_id = 2のダミーレコード10行
            ['word' => '犬も歩けば棒に当たる','user_id' => 2,'lank' => 1],
            ['word' => '当たるも八卦当たらぬも八卦','user_id' => 2,'lank' => 2],
            ['word' => '人間万事塞翁が馬','user_id' => 2,'lank' => 3],
            ['word' => '触らぬ神に祟りなし','user_id' => 2,'lank' => 1],
            ['word' => '虎穴に入らずんば虎子を得ず','user_id' => 2,'lank' => 2],
            ['word' => '犬も歩けば棒に当たる','user_id' => 2,'lank' => 1],
            ['word' => '当たるも八卦当たらぬも八卦','user_id' => 2,'lank' => 2],
            ['word' => '人間万事塞翁が馬','user_id' => 2,'lank' => 3],
            ['word' => '触らぬ神に祟りなし','user_id' => 2,'lank' => 1],
            ['word' => '虎穴に入らずんば虎子を得ず','user_id' => 2,'lank' => 2],
        ]);
    }
}
