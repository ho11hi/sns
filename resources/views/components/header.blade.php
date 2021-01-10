<header>
   <div class="header-logo"><a href="{{ route('posts.index') }}">SimpleSNS</a></div>
   @if(auth()->user())
   <ul class="header-menus">
      <li><a href="{{ route('users.show',Auth::id()) }}">{{ Auth::user()->name }}</a>
      </li>
      <li><a href="{{ route('posts.index') }}">投稿一覧</a></li>
      <li><a href="{{ route('posts.create') }}">新規投稿</a></li>
      <li><a href="{{ route('users.index') }}">ユーザー一覧</a></li>
      <li><a href="{{ route('logout') }}"
            onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">ログアウト</a></li>
      <form id="logout-form"
         action="{{ route('logout') }}"
         method="POST"
         style="display: none;">
         @csrf
      </form>
   </ul>
</header>
@else
<ul class="header-menus">
   <li><a href="{{ route('register') }}">新規登録</a></li>
   <li><a href="{{ route('login') }}">ログイン</a></li>
</ul>
@endif
</header>
