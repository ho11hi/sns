<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
use PostsTableSeeder;

class PostsTableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // ***********************************************
    // テーブルと、そのカラムの確認
    // ***********************************************
    /** @test */
    public function have_the_posts_table_and_columns()
    {
        $this->assertTrue(Schema::hasTable('posts'));
        $this->assertTrue(Schema::hasColumns(
            'posts',
            ['id', 'content', 'created_at', 'updated_at', 'user_id']
        ));
    }

    // ***********************************************
    // 挿入・削除確認
    // ***********************************************
    /**
     * @test
     */
    public function insert_data_to_posts_table()
    {
        $this->seed(PostsTableSeeder::class);
        $count = Post::all()->count();

        for ($i = 1; $i <= $count; $i++) {
            $posts[$i] = Post::find($i)->toArray();
            $this->assertDatabaseHas('posts', $posts[$i]);

            Post::find($i)->delete();
            $this->assertDatabaseMissing('posts', $posts[$i]);
        }
    }

    /** @test */
    public function insert_exception_for_posts_table()
    {
        // 通常挿入（正常系）
        $data = [
            'content' => 'こんにちは',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1,
        ];
        $post = new Post();
        $post->fill($data)->save();
        $this->assertDatabaseHas('posts', $data);


        // contentなし（異常系）
        try {
            $data = [
                // 'content' => 'こんにちは',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 1,
            ];
            $post = new Post();
            $post->fill($data)->save();
        } catch (\Throwable $th) {
            $this->assertSame('HY000', $th->getCode());
        }

        // user_idなし（異常系）
        try {
            $data = [
                'content' => 'こんにちは',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                // 'user_id' => 1,
            ];
            $post = new Post();
            $post->fill($data)->save();
        } catch (\Throwable $th) {
            $this->assertSame('HY000', $th->getCode());
        }
    }
}
