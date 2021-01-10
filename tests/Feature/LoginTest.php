<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    use RefreshDatabase;


    // *******************************************
    // ログイン認証
    // *******************************************
    /** @test */
    public function login_user_ok()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('root')
        ]);
        $this->assertFalse(Auth::check());

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'root'
        ]);
        $this->assertTrue(Auth::check());
        $response->assertRedirect('posts');
    }

    /** @test password間違えチェック */
    public function login_user_fail()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('root')
        ]);
        $this->assertFalse(Auth::check());

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'roo'
        ]);
        $this->assertFalse(Auth::check());
        $response->assertRedirect('');
    }

    /** @test email間違えチェック */
    public function login_user_fail2()
    {
        $user = factory(User::class)->create([
            'email' => 'text1@exmaple.com',
            'password' => bcrypt('root')
        ]);
        $this->assertFalse(Auth::check());

        $response = $this->post('login', [
            'email' => 'text2@exmaple.com',
            'password' => 'root'
        ]);
        $this->assertFalse(Auth::check());
        $response->assertRedirect('');
    }

    // *******************************************
    // ログインバリデーション
    // *******************************************
    /** @test */
    public function email_invalid_user_cannot_login()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('root')
        ]);

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'roo'
        ]);
        $error = session('errors')->first('email');
        $this->assertEquals('ログイン情報が登録されていません。', $error);
    }

    /** @test */
    public function invalid_user_cannot_login_empty()
    {
        $user = factory(User::class)->create();

        $response = $this->post('login', [
            'email' => null,
            'password' => null
        ]);

        $error_email = session('errors')->first('email');
        $this->assertEquals('メールアドレスは必ず指定してください。', $error_email);

        $error_pass = session('errors')->first('password');
        $this->assertEquals('パスワードは必ず指定してください。', $error_pass);
    }

    // *******************************************
    // ログアウト
    // *******************************************
    /** @test */
    public function logout()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->post('logout');
        $this->assertFalse(Auth::check());
        $response->assertRedirect('login');

        $sess = session();
    }
}
