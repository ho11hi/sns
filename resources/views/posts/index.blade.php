@extends('layouts.app')
@section('title','ホーム')

@section('content')
<div class="main posts-index">
   <div class="container -list">
      <div class="heading">投稿一覧</div>

      @foreach($posts as $post)
      <div class="posts-index-item">
         <div class="post-left">
            <img
               @if($post->image_name === null)
            src="{{ asset('assets/default-user-image.png') }}"
            @else
            src="{{ asset('storage/user_img/'.$post->image_name) }}"
            @endif
            >
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
