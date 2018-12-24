<!DOCTYPE html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/Bootstrap-sticky-footer.css') }}" type="text/css">
    <title>エラーページ</title>
  </head>
  <body>
    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand ml-5" href="{{ action('IndexController@index') }}">
          {{ config('app.name', 'ことコレ') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
          <ul class="navbar-nav">
            @guest
              <li class="nav-item">
                <a class="nav-link text-light mr-5" href="{{ route('register') }}">新規登録</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light mr-5" href="{{ route('login') }}">ログイン</a>
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link text-light mr-5" href="{{ action('WordController@share_word_index') }}">みんなの言葉</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light mr-5" href="{{ action('UserController@userinfo_index') }}">ユーザー設定</a>
              </li>
              <li class="nav-item">
                <span class="nav-link text-light mr-5">{{ Auth::user()->name }}</span>
              </li>
              <li class="nav-item">
                <a href="{{ route('logout') }}"
                  class="nav-link text-light mr-5"
                  onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                  ログアウト
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            @endguest
          </ul>
        </div>
      </nav>
    </header>
    
    <main class="mb-5">
        @yield('content')
    </main>

    <footer class="footer">
      <div class="container">
        <!-- <span class="text-light">Place sticky footer content here.</span> -->
        <p class="text-center text-light">Copy right @ 
          <u><a class="text-light" href="https://github.com/kakedashi" target="_blank">GitHub by kakedashi</a></u>
        </p>
      </div>
    </footer>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- 画像ファイル名を取得して表示　-->
    <script type="text/javascript">
      $(document).on('change', ':file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.parent().parent().next(':text').val(label);
      });
    </script>
  </body>
</html>