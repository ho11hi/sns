<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PostsTableSeeder;
use UsersTableSeeder;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $this->seed();

            // ユーザー登録テスト
            $browser->visit('/login')
                ->type('email', 'test1@example.com')
                ->type('password', 'root')
                ->press('ログイン')
                ->assertPathIs('*/posts');

            // tabテスト
            $browser->visit('/users/1')
                ->click('.user-tabs > li:nth-child(2)')
                ->assertSee('今日のランチおいしかった。')
                ->click('.user-tabs > li:nth-child(1)')
                ->assertSee('次は何の本を読もうかな。');


            $browser->visit('users/1/edit')
                ->assertSee('アカウント編集')
                ->attach('image_name', __DIR__ . '/test.jpg')
                ->press('保存');
        });
    }
}
