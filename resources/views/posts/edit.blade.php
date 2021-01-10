@extends('layouts.app')
@section('title','編集')

@section('content')
<div class="main posts-new">
   <div class="container">
      <h1 class="heading">編集する</h1>
      <form action="{{ route('posts.update',$post->id) }}"
         method="post" class="form">
         @csrf
         @method('PUT')
         <div class="form-body">
            @error('content')
            <div class="form-error">{{ $message }}</div>
            @enderror
            <textarea name="content">{{ $post->content }}</textarea>
            <input type="submit" value="保存">
         </div>
      </form>
   </div>
</div>
@endsection
