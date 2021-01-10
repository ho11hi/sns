<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\User;

class FlashTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function at_register()
    {
        $response = $this->post('register', [
            'name' => '山田太郎1',
            'email' => 'test1@example.com',
            'password' => 'root',
            'password_confirmation' => 'root'
        ]);

        $flash = session('flash_message');
        $this->assertEquals('登録が完了しました', $flash);
    }

    /** @test */
    public function at_login_and_logout()
    {
        // login
        $user = factory(User::class)->create([
            'password' => bcrypt('root')
        ]);
        $this->assertFalse(Auth::check());

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'root'
        ]);

        $flash = session('flash_message');
        $this->assertEquals('ログインしました', $flash);

        // logout
        $response = $this->post('logout');
        $flash = session('flash_message');
        $this->assertEquals('ログアウトしました', $flash);
    }

    /**
     * @test
     * 不正な値の入力
     */
    public function invalid_param()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------


    }
}
