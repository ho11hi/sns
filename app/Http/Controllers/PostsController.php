<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\User;
use App\Like;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::table('users')
            ->rightJoin('posts', 'users.id', '=', 'posts.user_id')
            ->orderBy('posts.id')
            ->get();

        return view('posts/index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post;
        Auth::user()->posts()->save($post->fill($request->all()));

        return redirect('posts')
            ->with('flash_message', '登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 投稿
        $post = DB::table('users')
            ->rightJoin('posts', 'users.id', '=', 'posts.user_id')
            ->where('posts.id', $id)
            ->first();

        // 時間
        $time = substr($post->created_at, 0, 10);

        // いいね有無
        $likes = DB::table('likes')
            ->where('user_id', Auth::id())
            ->where('post_id', '=', $post->id)
            ->first();

        // LIKEカウント
        $likecnt = DB::table('likes')
            ->select(DB::raw('post_id, count(*) as count'))
            ->where('post_id', $post->id)
            ->groupBy('post_id')
            ->first();

        if ($likecnt === null) {
            $likecnt['post_id'] = $post->id;
            $likecnt['count'] = 0;
        }

        return view('posts/show', compact('post', 'time', 'likes', 'likecnt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Auth::user()->posts()->find($id);

        if ($post) {
            return view('posts/edit', compact('post'));
        } else {
            return redirect()->route('posts.index')
                ->with('error_message', '不正な値が入力されました');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Auth::user()->posts()->find($id);
        $post->fill($request->all())->save();
        // Auth::user()->posts()->save($post->fill($request->all()));

        return redirect('posts')
            ->with('flash_message', '登録しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->posts()->find($id)->delete(); // 投稿の削除
        Like::where('post_id', $id)->delete(); //お気に入りの削除

        return redirect()->route('posts.index')
            ->with('flash_message', '削除しました');
    }
}
