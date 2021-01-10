@extends('layouts.app')
@section('title','ホーム')

@section('content')
<div class="main posts-index">
   <div class="container">

      {{-- @dump($posts) --}}
      @foreach($posts as $post)
         <div class="posts-index-item">
            <div class="post-left">
               <img src="{{ asset('storage/user_img/'.$post->image_name) }}">
            </div>
            <div class="post-right">
               <div class="post-user-name">
                  <a href="{{ route('users.show',$post->user_id) }}">{{ $post->name }}</a>
               </div>
               <a
                  href="{{ route('posts.show',$post->id) }}">P{{ $post->id }}:{{ $post->content }}</a>
            </div>
         </div>
      @endforeach
   </div>
</div>
@endsection
