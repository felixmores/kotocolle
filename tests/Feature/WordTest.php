<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Word;
use App\Models\User;

class WordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * マイページ画面を表示
     *
     * @return void
     */
    public function testMypageIndex()
    {
        $response = $this->get('/mypage');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/mypage');
        $response->assertSuccessful();

        $user = factory(User::class)->states('管理者')->create();
        $response = $this->actingAs($user)->get('/mypage');
        $response->assertRedirect('/');
    }

    /**
     * 言葉登録画面を表示
     * 
     * @return void
     */
    public function testAddWordIndex() {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/mypage/add_word');
        $response->assertSuccessful();

        $user = factory(User::class)->states('管理者')->create();
        $response = $this->actingAs($user)->get('/mypage/add_word');
        $response->assertRedirect('/');
    }

    /**
     * 言葉の詳細画面を表示
     * 
     * @return void
     */
    public function testWordContentIndex() {

        $user_3 = factory(User::class)->states('id:3')->create();
        $word_3 = factory(Word::class)->states('id:3, user_id:3, share_flag:1')->create();
        $response = $this->get('/word_content/3/3');
        $response->assertSuccessful();

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/word_content/1/1');
        $response->assertRedirect('/mypage');

        $user_2 = factory(User::class)->states('id:2')->create();
        $word_2 = factory(Word::class)->states('id:2, user_id:2')->create();
        $response = $this->actingAs($user_2)->get('/word_content/2/2');
        $response->assertSuccessful();

        $response = $this->actingAs($user_2)->get('/word_content/3/3');
        $response->assertSuccessful();

        $user_4 = factory(User::class)->states('id:4')->create();
        $word_4 = factory(Word::class)->states('id:4, user_id:4, share_flag:0')->create();
        $response = $this->actingAs($user_2)->get('/word_content/4/4');
        $response->assertRedirect('/mypage');

        $admin = factory(User::class)->states('管理者')->create();
        $response = $this->actingAs($admin)->get('/word_content/2/2');
        $response->assertSuccessful();
    }

    /**
     * 言葉編集画面を表示
     * 
     * @return void
     */
    public function testEditWord() {
        $user_2 = factory(User::class)->states('id:2')->create();
        $response = $this->actingAs($user_2)->get('/word_content/2/2/edit_word');
        $response->assertRedirect('/mypage');

        $word_2 = factory(Word::class)->states('id:2, user_id:2')->create();
        $response = $this->actingAs($user_2)->get('/word_content/2/2/edit_word');
        $response->assertSuccessful();

        $user_3 = factory(User::class)->states('id:3')->create();
        $word_3 = factory(Word::class)->states('id:3, user_id:3, share_flag:1')->create();
        $response = $this->actingAs($user_2)->get('/word_content/3/3/edit_word');
        $response->assertRedirect('/mypage');
    }

    /**
     * シェアした言葉の一覧画面を表示
     * 
     * @return void
     */
    public function testShareWord() {
        $response = $this->get('/shareword');
        $response->assertSuccessful();

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/shareword');
        $response->assertSuccessful();
    }

    /**
     * 登録ユーザーの言葉一覧画面を表示(管理画面)
     * 
     * @return void
     */
    public function testWordsList() {
        $user_2 = factory(User::class)->states('id:2')->create();
        $word_2 = factory(Word::class)->states('id:2, user_id:2')->create();
        $response = $this->actingAs($user_2)->get('/users/words/2');
        $response->assertRedirect('/');

        $admin = factory(User::class)->states('管理者')->create();
        $response = $this->actingAs($admin)->get('/users/words/2');
        $response->assertSuccessful();
    }
}
