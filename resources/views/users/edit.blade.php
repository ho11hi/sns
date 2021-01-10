@extends('layouts.app')
@section('title',
'アカウント編集')

@section('content')
<div class="main users-edit">
   <div class="container">
      <div class="heading">アカウント編集</div>
      <form method="POST" action="{{ route('users.update',Auth::id()) }}"
         class="form users-form" enctype="multipart/form-data">
         @csrf
         @method('PUT')
         <div class="form-body">

            <p>ユーザー名</p>
            @error('name')
            <div class="form-error">{{ $message }}</div>
            @enderror
            <input name="name" value="{{ $user->name }}">

            <p>画像</p>
            @error('image_name')
            <div class="form-error">{{ $message }}</div>
            @enderror
            <input name="image_name" type="file">

            <p>メールアドレス</p>
            @error('email')
            <div class="form-error">{{ $message }}</div>
            @enderror
            <input name="email" value="{{ $user->email }}">
            <input type="submit" value="保存">

         </div>
      </form>
   </div>
</div>
@endsection
