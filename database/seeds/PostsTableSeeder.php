<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'id' => 1,
            'content' => '今日のご飯はなにかな？',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'id' => 2,
            'content' => 'コーヒー買いに行かなきゃ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'id' => 3,
            'content' => '筋肉痛で動けない',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'id' => 4,
            'content' => '今日は図書館から本を借りた',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'id' => 5,
            'content' => 'とにかく、たこ焼きが食べたい',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'id' => 6,
            'content' => '外が寒くて、玄関のバケツの中の水が凍ってたよ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 5,
        ]);
        DB::table('posts')->insert([
            'id' => 7,
            'content' => '早く、コロナが落ち着いてくれればなぁー',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1,
        ]);
    }
}
