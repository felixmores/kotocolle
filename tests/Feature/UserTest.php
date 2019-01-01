<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * ユーザー情報表示画面
     *
     * @return void
     */
    public function testUserInfoIndex()
    {
        $response = $this->get('/userinfo');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/userinfo');
        $response->assertSuccessful();
        $response->assertViewHas('image_name', 'no_user_image.gif');

        $user = factory(User::class)->states('画像あり')->create();
        $response = $this->actingAs($user)->get('/userinfo');
        $response->assertSuccessful();
        $response->assertViewHas('image_name', 'example.jpg');
    }

    /**
     * ユーザー情報編集画面を表示
     * 
     * @return void
     */
    public function testUserInfoEdit() {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/userinfo/edit');
        $response->assertSuccessful();
    }

    /**
     * パスワード変更画面を表示
     * 
     * @return void
     */
    public function testPassWordEdit() {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/userinfo/password_edit');
        $response->assertSuccessful();
    }

    /**
     * 登録ユーザー一覧表示(管理画面)
     * 
     * @return void
     */
    public function testUsersListIndex() {
        $response = $this->get('/users');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        
        $user = factory(User::class)->states('管理者')->create();
        $response = $this->actingAs($user)->get('/users');
        $response->assertSuccessful();
    }
}