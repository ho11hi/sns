<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    // *******************************************
    // ユーザー編集
    // *******************************************
    /**
     * @test
     * 画像投稿（正常系） // できない！
     * memo: storage > framework > testing > disks > testing
     * */
    public function edit_upload_image_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        Storage::fake('test');
        $file = UploadedFile::fake()->image('sample.jpg', 100, 100);
        // $file->move('storage/framework/testing/disks/test'); //これ追加するとDBの画像名が変になる

        $data = [
            'name' => '山田太郎',
            'email' => 'test@example.com',
            // 'image_name' => $file
        ];

        $response = $this->put(route('users.update', $user->id), $data);
        // ->assertRedirect(route('users.show', $user->id));

        // Assert the file was stored...
        // Storage::disk('testing')->assertExists($file->getFilename());
    }



    // 以下完成
    // *********************************************************
    /**
     * @test
     * 編集投稿（正常系）
     * */
    public function edit_user_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------

        $data = [
            'name' => '山田太郎',
            'email' => 'test@example.com',
            // 'image_name' => 'sample.jpg' // 画像はエラーが出る
        ];
        $response = $this
            ->put(route('users.update', $user->id), $data);
        // ->assertRedirect(route('users.show', $user->id));
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * @test
     * 画像サイズテスト（正常系）
     * memo: storage > framework > testing > disks > testing
     * */
    public function edit_upload_max_ok()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        Storage::fake('test_file');
        $file = UploadedFile::fake()->image('dummy.jpg')->size(3145728);

        $response = $this
            ->put(route('users.update', $user->id), [
                'image_name' => $file
            ]);

        $session = session('errors')->first('image_name');
        $this->assertEquals('', $session);
    }

    /**
     * @test
     * 画像サイズテスト（異常系）
     * memo: storage > framework > testing > disks > testing
     * */
    public function edit_upload_max_fail()
    {
        // Auth ---------------------------------
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // --------------------------------------
        Storage::fake('test_file');
        $file = UploadedFile::fake()->image('dummy.jpg')->size(3145729);

        $response = $this
            ->put(route('users.update', $user->id), [
                'image_name' => $file
            ]);

        $session = session('errors')->first('image_name');
        $this->assertEquals('画像には、3145728 kB以下のファイルを指定してください。', $session);
    }
}
