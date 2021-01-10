<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Like;
use Illuminate\Support\Facades\Schema;
use LikesTableSeeder;
use Illuminate\Support\Carbon;

class LikesTableTest extends TestCase
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
    public function have_the_likes_table_and_columns()
    {
        $this->assertTrue(Schema::hasTable('likes'));
        $this->assertTrue(Schema::hasColumns(
            'likes',
            ['user_id', 'post_id', 'created_at', 'updated_at']
        ));
    }

    // ***********************************************
    // 挿入・削除確認
    // ***********************************************
    /**
     * @test
     */
    public function insert_data_to_users_table()
    {
        $this->seed(LikesTableSeeder::class);
        $count = Like::all()->count();
        $all = Like::all()->toArray();

        for ($i = 0; $i < $count; $i++) {
            $this->assertDatabaseHas('likes', $all[$i]);

            Like::where('user_id', $all[$i]['user_id'])
                ->where('post_id', $all[$i]['post_id'])
                ->delete();
            $this->assertDatabaseMissing('likes', $all[$i]);
        }
    }

    // ***********************************************
    // 条件付きの挿入（INSERT）
    // ***********************************************
    /** @test */
    public function insert_exception_for_likes_table()
    {
        // 通常
        $data = [
            'user_id' => 1,
            'post_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $like = new Like();
        $like->fill($data)->save();
        $this->assertDatabaseHas('likes', $data);

        // user_idなし
        try {
            $data = [
                // 'user_id' => 1,
                'post_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $like = new Like();
            $like->fill($data)->save();
        } catch (\Throwable $th) {
            $this->assertSame('HY000', $th->getCode());
        }

        // post_idなし
        try {
            $data = [
                'user_id' => 1,
                // 'post_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $like = new Like();
            $like->fill($data)->save();
        } catch (\Throwable $th) {
            $this->assertSame('HY000', $th->getCode());
        }
    }
}
