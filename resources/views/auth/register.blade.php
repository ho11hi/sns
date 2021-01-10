@extends('layouts.app')
@section('title','新規登録')

@section('content')
<div class="main users-new">
   <div class="container">
      <div class="heading">新規ユーザー登録</div>
      <form method="POST" action="{{ route('register') }}" class="form users-form">
         @csrf

         <div class="form-body">
            <p>ユーザー名</p>
            @error('name')
            <div class="form-error" role="alert">
               {{ $message }}
            </div>
            @enderror
            <input name="name" value="{{ old('name') }}"
               class="@error('name')is-invalid @enderror" autocomplete="name"
               autofocus>

            <p>メールアドレス</p>
            @error('email')
            <div class="form-error" role="alert">
               {{ $message }}
            </div>
            @enderror
            <input name="email" value="{{ old('email') }}" type="email"
               class="@error('email')is-invalid @enderror" autocomplete="email">

            <p>パスワード</p>
            @error('password')
            <div id="password" class="form-error" role="alert">
               {{ $message }}
            </div>
            @enderror
            <input type="password" name="password" class="@error('password')is-invalid @enderror"
               autocomplete="new-password">

            <p>パスワード再入力</p>
            <input id="password-confirm" type="password" name="password_confirmation"
               class="@error('password')is-invalid @enderror"
               autocomplete="new-password">

            <input type="submit" value="新規登録">
         </div>
      </form>
   </div>
</div>
@endsection
