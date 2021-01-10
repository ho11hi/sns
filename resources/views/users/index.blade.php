@extends('layouts.app')
@section('title',
'ユーザー一覧')

@section('content')
<div class="main users-index">
   <div class="container">
      <h1 class="users-heading">ユーザー一覧</h1>

      {{-- @dump($users) --}}
      @foreach($users as $user)
         <div class="users-index-item">
            <div class="user-left">
               <img src="{{ asset('storage/user_img/'.$user->image_name) }}">
            </div>
            <div class="user-right">
               <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
            </div>
         </div>
      @endforeach

   </div>
</div>
@endsection
