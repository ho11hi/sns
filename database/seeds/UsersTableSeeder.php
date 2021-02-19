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
            'name' => 'guest user',
            'email' => 'guest@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => null,
            'password' => Hash::make('password'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'name' => 'test1',
            'email' => 'test1@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => null,
            'password' => Hash::make('rootroot'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'name' => 'test2',
            'email' => 'test2@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => null,
            'password' => Hash::make('rootroot'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'name' => 'test3',
            'email' => 'test3@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => null,
            'password' => Hash::make('rootroot'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'name' => 'test4',
            'email' => 'test4@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => null,
            'password' => Hash::make('rootroot'),
            'api_token' => Str::random(80)
        ]);
        DB::table('users')->insert([
            'name' => 'test5',
            'email' => 'test5@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'image_name' => null,
            'password' => Hash::make('rootroot'),
            'api_token' => Str::random(80)
        ]);
    }
}
