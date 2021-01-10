@extends('layouts.app')
@section('title',
'ユーザー一覧')

@section('content')
<div class="main user-show">
   <div class="container">
      <div class="user">
         <h2>{{ $user->name }}</h2>
         <img src="{{ asset('storage/user_img/'.$user->image_name) }}">
         {{-- <p>{{ $user->email }}</p> --}}
         @if(Auth::id() === $user->id)
         <a href="{{ route('users.edit',$user->id) }}" style="display: block;">プロフィール編集</a>
         @endif
      </div>
      <show-component
         :user="{{ json_encode($user) }}"
         :posts="{{ json_encode($posts) }}"
         :likes="{{ json_encode($likes) }}"
         :path="{{ json_encode(asset('')) }}">
      </show-component>

   </div>
</div>


@endsection
