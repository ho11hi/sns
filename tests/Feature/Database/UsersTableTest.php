<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use UsersTableSeeder;

class UsersTableTest extends TestCase
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
    public function have_the_users_table_and_columns()
    {
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasColumns(
            'users',
            ['id', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'image_name']
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
        $this->seed(UsersTableSeeder::class);
        $count = User::all()->count();

        for ($i = 1; $i <= $count; $i++) {
            $person[$i] = User::find($i)->toArray();
            $this->assertDatabaseHas('users', $person[$i]);

            User::find($i)->delete();
            $this->assertDatabaseMissing('users', $person[$i]);
        }
    }

    // ***********************************************
    // 条件付きの挿入（INSERT）
    // ***********************************************
    /** @test */
    public function insert_exception()
    {
        // 名前カラムなしので挿入（正常系）
        $data = [
            'name' => 'にんじゃわんこ',
            'email' => 'test1@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            // 'image_name' => 'default_user.jpg',
            'password' => Hash::make('root'),
        ];
        $user = new User();
        $user->fill($data)->save();
        $this->assertDatabaseHas('users', $data);


        // メールカラムなしので挿入（異常系）
        try {
            $data = [
                'name' => 'にんじゃわんこ',
                // 'email' => 'test1@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'image_name' => 'default_user.jpg',
                'password' => Hash::make('root'),
            ];
            $user = new User();
            $user->fill($data)->save();
        } catch (\Throwable $th) {
            $this->assertSame('HY000', $th->getCode());
        }


        // 名前カラムなしので挿入（異常系）
        try {
            $data = [
                // 'name' => 'にんじゃわんこ',
                'email' => 'test1@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'image_name' => 'default_user.jpg',
                'password' => Hash::make('root'),
            ];
            $user = new User();
            $user->fill($data)->save();
        } catch (\Throwable $th) {
            $this->assertSame('HY000', $th->getCode());
        }
    }
}
