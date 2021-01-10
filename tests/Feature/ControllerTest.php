<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;
use App\Like;

class ControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/')->assertStatus(200);
    }

    /** test */
    public function routes()
    {
        // *******************************************
        // ログイン前
        // *******************************************
        // 200 status
        $response = $this->get('login')->assertSeeText('ログイン');
        $response = $this->get('register')->assertSeeText('新規ユーザー登録');

        // 302 status
        $response = $this->get('posts')->assertStatus(302);
        $response = $this->get('posts/show')->assertStatus(302);
        $response = $this->get('posts/create')->assertStatus(302);
        $response = $this->get('posts/edit')->assertStatus(302);
        $response = $this->get('users')->assertStatus(302);
        $response = $this->get('users/show')->assertStatus(302);
        $response = $this->get('users/create')->assertStatus(302);
        $response = $this->get('users/edit')->assertStatus(302);

        // *******************************************
        // ログイン時
        // *******************************************
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $like = factory(Like::class)->create();
        $response = $this->actingAs($user);
        $response = $this->get('posts')->assertStatus(200);
        $response = $this->get('posts/1')->assertStatus(200);
        $response = $this->get('posts/create')->assertStatus(200);
        $response = $this->get('posts/1/edit')->assertStatus(200);
        $response = $this->get('users')->assertStatus(200);
        $response = $this->get('users/1')->assertStatus(200);
        $response = $this->get('users/1/edit')->assertStatus(200);

        // *******************************************
        // 対応なしのルート
        // *******************************************
        $response = $this->get('users/create')->assertStatus(500);
    }
}
