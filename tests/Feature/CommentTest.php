<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Word;
use App\Models\User;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * コメントを表示する
     *
     * @return void
     */
    public function testCommentIndex()
    {
        $user_2 = factory(User::class)->states('id:2')->create();
        $word_2 = factory(Word::class)->states('id:2, user_id:2')->create();
        $comment_2 = factory(Comment::class)->states('word_id:2, user_id:2')->create();
        $response = $this->actingAs($user_2)->get('/word_content/2/2');
        $response->assertSee($comment_2->comment);

        $user_3 = factory(User::class)->states('id:3')->create();
        $word_3 = factory(Word::class)->states('id:3, user_id:3, share_flag:1')->create();
        $comment_3 = factory(Comment::class)->states('word_id:3, user_id:3')->create();
        $response = $this->actingAs($user_2)->get('/word_content/3/3');
        $response->assertSee($comment_3->comment);

        $admin = factory(User::class)->states('管理者')->create();
        $response = $this->actingAs($admin)->get('/word_content/2/2');
        $response->assertSee($comment_2->comment);
    }
}
