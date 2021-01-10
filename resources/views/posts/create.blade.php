@extends('layouts.app')
@section('title','ホーム')

@section('content')
<div class="main posts-new">
   <div class="container">
      <h1 class="heading">投稿する</h1>
      <form method="POST" action="{{ route('posts.store') }}" class="form">
         @csrf
         <div class="form-body">
            @error('content')
            <div class="form-error">{{ $message }}</div>
            @enderror

            <textarea name="content"></textarea>
            <input type="submit" value="投稿">
         </div>
      </form>
   </div>
</div>
@endsection
