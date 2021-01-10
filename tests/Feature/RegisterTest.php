<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    // *******************************************
    // 登録確認テスト
    // *******************************************
    /**
     * @test
     * 通常の登録（正常系）
     * */
    public function register_user()
    {
        $this->assertFalse(Auth::check());

        $response = $this->post('register', [
            'name' => '山田太郎1',
            'email' => 'test1@example.com',
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertTrue(Auth::check()); // Auth確認
        $response->assertRedirect('posts'); // リダイレクト確認
    }

    /**
     * @test
     * 空値の入力（異常系）
     * */
    public function register_empty()
    {
        $response = $this->post('register', [
            'name' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null
        ]);

        $error_name = session('errors')->first('name');
        $this->assertEquals('名前は必ず指定してください。', $error_name);

        $error_email = session('errors')->first('email');
        $this->assertEquals('メールアドレスは必ず指定してください。', $error_email);

        $error_pass = session('errors')->first('password');
        $this->assertEquals('パスワードは必ず指定してください。', $error_pass);
    }


    // *******************************************
    // name
    // *******************************************
    /**
     * @test
     * 名前文字数の境界値テスト（正常系）
     * */
    public function register_name_max_ok()
    {
        $response = $this->post('register', [
            'name' => Str::random(50),
            'email' => 'test1@example.com',
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertTrue(Auth::check()); // Auth確認
        $response->assertRedirect('posts'); // リダイレクト確認
    }

    /**
     * @test
     * 名前文字数の境界値テスト（異常系）
     * */
    public function register_name_max_fail()
    {
        $response = $this->post('register', [
            'name' => Str::random(51),
            'email' => 'test1@example.com',
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertFalse(Auth::check());
        $error = session('errors')->first('name');
        $this->assertEquals('名前は、50文字以下で指定してください。', $error);
    }

    // *******************************************
    // email
    // *******************************************
    /**
     * @test
     * メール形式テスト（異常系）
     * */
    public function register_email_format_fail()
    {
        $response = $this->post('register', [
            'name' => '山田太郎2',
            'email' => 'test1example.com',
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertFalse(Auth::check());
    }

    /**
     * @test
     * メール文字数テスト（正常系）
     * */
    public function register_email_max_ok()
    {
        $response = $this->post('register', [
            'name' => '山田太郎3',
            'email' => Str::random(88) . '@example.com', // 88文字+12文字=100文字
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertTrue(Auth::check());
        $response->assertRedirect('posts'); // リダイレクト確認

    }

    /**
     * @test
     * メール文字数テスト（異常系）
     * */
    public function register_email_max_fail()
    {
        $response = $this->post('register', [
            'name' => '山田太郎4',
            'email' => Str::random(89) . '@example.com', // 89文字+12文字=101文字
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertFalse(Auth::check());
        $error = session('errors')->first('email');
        $this->assertEquals('メールアドレスは、100文字以下で指定してください。', $error);
    }

    /**
     * @test
     * メール重複テスト（異常系）
     * */
    public function register_email_unique_fail()
    {
        $user = new User;
        $user->name = '山田太郎';
        $user->email = 'test@example.com';
        $user->password = 'root';
        $user->save();

        $response = $this->post('register', [
            'name' => '山田太郎5',
            'email' => 'test@example.com',
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertFalse(Auth::check());
        $error = session('errors')->first('email');
        $this->assertEquals('メールアドレスの値は既に存在しています。', $error);
    }

    // *******************************************
    // password
    // *******************************************
    /**
     * @test
     * メール文字数テスト（正常系）
     * */
    public function register_pass_min_ok()
    {
        $response = $this->post('register', [
            'name' => '山田太郎6',
            'email' => 'test@example.com',
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $this->assertTrue(Auth::check());
        $response->assertRedirect('posts');
    }

    /**
     * @test
     * メール文字数テスト（異常系）
     * */
    public function register_pass_min_fail()
    {
        $response = $this->post('register', [
            'name' => '山田太郎6',
            'email' => 'test@example.com',
            'password' => 'roo',
            'password_confirmation' => 'roo'
        ]);

        $this->assertFalse(Auth::check());
        $error = session('errors')->first('password');
        $this->assertEquals('パスワードは、4文字以上で指定してください。', $error);
    }
}
