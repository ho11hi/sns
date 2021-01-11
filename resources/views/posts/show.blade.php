@extends('layouts.app')
@section('title','投稿詳細')

@section('content')
<div class="main posts-show">
   <div class="container">


      <div class="posts-show-item">
         <div class="post-time">{{ $time }}</div>
         <div class="post-user-name">
            <a href="{{route('users.show',$post->user_id)}}">
               <img
                  @if($post->image_name === null)
               src="{{ asset('assets/default-user-image.png') }}"
               @else
               src="{{ asset('storage/user_img/'.$post->image_name) }}"
               @endif
               >
            </a>

            <a href="">{{ $post->name }}</a>
         </div>
         <p>{{ $post->content }}</p>
         {{-- <div class="post-time">{{ $time }}
      </div> --}}

      {{-- @dump($likes) --}}
      <like-component
         :post="{{ json_encode($post) }}"
         :likes="{{ json_encode($likes) }}"
         :likecnt="{{ json_encode($likecnt) }}"
         :path="{{ json_encode(asset('/')) }}"
         :user_id="{{ json_encode(Auth::id()) }}">
      </like-component>

      @if(Auth::id() === $post->user_id)
      <div class="post-menus">
         <a href="{{ route('posts.edit',$post->id) }}">編集</a>
         <form action="{{ route('posts.destroy',$post->id) }}"
            method="post">
            @csrf
            @method('DELETE')
            <input type="submit" value="削除" onclick='return confirm("削除しますか？");'>
         </form>
      </div>
      @endif
   </div>

</div>
</div>
@endsection
