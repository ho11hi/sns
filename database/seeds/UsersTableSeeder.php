<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'test1',
            'email' => 'test1@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => 'default_user.jpg',
            'password' => Hash::make('root'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'test2',
            'email' => 'test2@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => '2.jpg',
            'password' => Hash::make('root'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'test3',
            'email' => 'test3@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => '3.png',
            'password' => Hash::make('root'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'id' => 4,
            'name' => 'test4',
            'email' => 'test4@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => '4.png',
            'password' => Hash::make('root'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'id' => 5,
            'name' => 'test5',
            'email' => 'test5@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => '5.png',
            'password' => Hash::make('root'),
            'api_token' => Str::random(80)
        ]);
    }
}
