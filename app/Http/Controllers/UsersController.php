<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommonRequest;
use Illuminate\Http\Request;
use App\User;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 現在表示中のアカウント
        $user = User::where('id', $id)->first();

        if ($user !== null) {
            // 投稿表示SQL
            $posts = DB::table('posts as p')
                ->select('p.user_id as u_id', 'p.id as p_id', 'p.content', 'u.name', 'u.image_name')
                ->leftJoin('users as u', 'p.user_id', '=', 'u.id')
                ->where('u.id', $id)
                ->get();

            // いいね！表示SQL
            $likes = DB::table('likes as l')
                ->select('l.user_id as l_u_id', 'l.post_id as p_id', 'p.content', 'p.user_id as u_id', 'u.name', 'u.image_name')
                ->leftJoin('posts as p', 'l.post_id', '=', 'p.id')
                ->leftJoin('users as u', 'p.user_id', '=', 'u.id')
                ->where('l.user_id', Auth::id())
                ->orderBy('l_u_id')->orderBy('p_id')
                ->get();

            return view('users/show', compact('user', 'posts', 'likes'));
        } else {
            return redirect('users');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::id() === (int)$id) {
            $user = Auth::user()->find($id);
            return view('users.edit', compact('user'));
        } else {
            return redirect('posts')->with('error_message', '不正な値が入力されました');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $user = User::find($id);

        // ストレージファイルに保存（もし前回、画像登録をしていた場合、その画像を削除）
        if ($request->image_name) {
            if ($user->image_name !== null) {
                Storage::delete('public/user_img/' . $user->image_name);
            }
            Storage::disk('public')
                ->putFile('user_img', $request->file('image_name'));
        }

        // DBに挿入
        $user->fill([
            'name' => $request->name,
            'image_name' => ($request->file()) ? $request->file('image_name')->hashName() : $user->image_name,
            'email' => $request->email
        ])->save();

        return redirect()->route('users.show', $id)
            ->with('flash_message', '編集しました');
    }
}
