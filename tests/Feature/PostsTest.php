<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    // *******************************************
    // 新規投稿
    // *******************************************
    /**
     * @test
     * 新規投稿（正常系）
     * */
    public function create_post_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $data = [
            'content' => 'みなさんこんにちは。',
            'user_id' => $user->id
        ];
        $response = $this
            ->post(route('posts.store'), $data)
            ->assertRedirect('posts');
        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * @test
     * 新規投稿：投稿文字数0（異常系）
     * */
    public function create_post_min_fail()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $data = [
            'content' => '',
            'user_id' => $user->id
        ];
        $response = $this->post(route('posts.store'), $data);

        $error = session('errors')->first('content');
        $this->assertEquals('投稿は必ず指定してください。', $error);
    }

    /**
     * @test
     * 新規投稿：投稿文字数max255（正常系）
     * */
    public function create_post_max_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $data = [
            'content' => Str::random(255),
            'user_id' => $user->id
        ];
        $response = $this
            ->post(route('posts.store'), $data)
            ->assertRedirect('posts');
    }

    /**
     * @test
     * 新規投稿：投稿文字数max255（異常系）
     * */
    public function create_post_max_fail()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $data = [
            'content' => Str::random(256),
            'user_id' => $user->id
        ];
        $response = $this->post(route('posts.store'), $data);

        $error = session('errors')->first('content');
        $this->assertEquals('投稿は、255文字以下で指定してください。', $error);
    }

    // *******************************************
    // 編集
    // *******************************************
    /**
     * @test
     * 編集投稿（正常系）
     * */
    public function edit_post_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $post = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        $data = [
            'content' => 'みなさんこんにち。',
        ];
        $response = $this
            ->put(route('posts.update', $post->id), $data)
            ->assertRedirect('posts');
        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * @test
     * 編集投稿：投稿文字数0（異常系）
     * */
    public function edit_post_min_fail()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $post = factory(Post::class)->create();

        $data = [
            'content' => '',
        ];
        $response = $this->put(route('posts.update', $post->id), $data);

        $error = session('errors')->first('content');
        $this->assertEquals('投稿は必ず指定してください。', $error);
    }

    /**
     * @test
     * 編集投稿：投稿文字数max255（正常系）
     * */
    public function edit_post_max_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $post = factory(Post::class)->create();

        $data = [
            'content' => Str::random(255),
        ];
        $response = $this->put(route('posts.update', $post->id), $data);

        $response = $this
            ->post(route('posts.store'), $data)
            ->assertRedirect('posts');
    }


    /**
     * @test
     * 編集投稿：投稿文字数max255（異常系）
     * */
    public function edit_post_max_fail()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $post = factory(Post::class)->create();

        $data = [
            'content' => Str::random(256),
        ];
        $response = $this->put(route('posts.update', $post->id), $data);

        $error = session('errors')->first('content');
        $this->assertEquals('投稿は、255文字以下で指定してください。', $error);
    }

    // *******************************************
    // 削除
    // *******************************************
    /**
     * @test
     * 削除（正常系）
     * */
    public function delete_post_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        $post = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this
            ->delete(route('posts.destroy', $post->id))
            ->assertRedirect('posts');
    }
}
