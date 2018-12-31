<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * トップページへの画面遷移
     *
     * @return void
     */
    public function testAccessIndex()
    {
        $this->assertTrue(true);

        $response = $this->get('/');
        $response->assertSuccessful();

        $response = $this->get('/no_route');
        $response->assertStatus(404);

        $response = $this->get('/mypage');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/mypage');

        $user = factory(User::class)->states('管理者')->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/users');
    }
}
