@extends('layouts.base')

@section('title', '言葉の詳細ページ')

@section('content')
  <div class="container">
    {{-- カード本体 --}}
    <div class="card mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary mb-0">言葉の確認</div>
      <div class="card-body border border-top-0 border-primary">
        {{-- 言葉 --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-3">言葉</div>
          <div class="col-sm-9">{{ $word_content->word }}</div>
        </div>

        {{-- 画像 --}}
        <figure class="figure row mb-4">
          @if ($env_check === 'heroku' && $image_name !== 'no_word_image.jpg')
          <img src="/uploads/word_images/{{ $image_name }}" class="img-thumbnail mx-auto d-block">
          @elseif ($env_check !== 'heroku' && $image_name !== 'no_word_image.jpg')
          <img src="/storage/word_images/{{ $image_name }}" class="img-thumbnail mx-auto d-block">
          @else
          <img src="/images/{{ $image_name }}" class="img-thumbnail mx-auto d-block">
          @endif
        </figure>

        {{-- ランク --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-3">ランク</div>
          @switch ($word_content->lank)
            @case (1)
              <div class="col-sm-9">金言</div>
              @break
            @case (2)
              <div class="col-sm-9">銀言</div>
              @break
            @case (3)
              <div class="col-sm-9">銅言</div>
              @break
            @default
              <div class="col-sm-9">ランクなし</div>
          @endswitch
        </div>

        {{-- 公開状態 --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-3">公開</div>
          @switch ($word_content->share_flag)
            @case (0)
              <div class="col-sm-9">OFF</div>
              @break
            @case (1)
              <div class="col-sm-9">ON</div>
              @break
          @endswitch
        </div>

        {{-- メモ --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-3">メモ</div>
          <div class="col-sm-9">{{ $word_content->memo }}</div>
        </div>

        {{-- 登録日時 --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-3">登録日時</div>
          <div class="col-sm-9">{{ $word_content->created_at }}</div>
        </div>

        {{-- 更新日時 --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-3">更新日時</div>
          <div class="col-sm-9">{{ $word_content->updated_at }}</div>
        </div>

        {{-- ボタン --}}
        <div class="row btn-group d-flex justify-content-center">
        @if ($login_id === $word_content->user_id || $admin_flag === 1)
          @if ($admin_flag !== 1)
          <div class="col-sm-6">
            <form action="{{ action('WordController@word_edit', ['user_id' => $word_content->user_id, 'word_id' => $word_content->id]) }}" method="GET">
              <button type="submit" class="btn btn-primary btn-lg mx-3">編集する</button>
            </form>
          </div>
          @endif
          <div class="col-sm-6">
            <form action="{{ action('WordController@word_delete', ['user_id' => $word_content->user_id, 'word_id' => $word_content->id]) }}" method="POST">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger btn-lg mx-3">削除する</button>
            </form>
          </div>
        @endif
        </div>
      </div>
    </div>

    {{-- コメント送信フォーム --}}
    <form action="{{ action('CommentController@comment_add', ['user_id' => $word_content->user_id, 'word_id' => $word_content->id]) }}" method="POST">
      {{ csrf_field() }}
      @auth
      {{-- エラーメッセージ --}}
      <div class="form-group">
        @if (count($errors) > 0)
        <div class="alert alert-danger mt-3" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        {{-- コメント入力欄 --}}
        <label for="comment" class="h5 mt-3">この言葉にコメント</label>
        <textarea name="comment" id="comment" class="form-control" rows="7">{{ old('comment') }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">コメントする</button>
      @endauth
    </form>

    {{-- コメント一覧 --}}
    <h5 class="mt-5 mb-3">コメント一覧</h5>
    @if (count($comment_all) > 0)
    <form action="{{ action('CommentController@comment_delete', ['user_id' => $word_content->user_id, 'word_id' => $word_content->id]) }}" method="POST">
      {{ csrf_field() }}
      @foreach ($comment_all as $comment_content)
      <ul class="list-group mb-3">
        <li class="list-group-item">{{ $comment_content->name }}</li>
        <li class="list-group-item">{{ $comment_content->comment }}</li>
        <li class="list-group-item mb-4">
          投稿日時：{{ $comment_content->created_at }}
          <input type="hidden" name="comment_id" value="{{ $comment_content->id }}">
          @if ($login_id === $comment_content->user_id || $admin_flag === 1)
          <button type="submit" class="btn btn-danger btn-sm">コメントを削除する</button>
          @endif
        </li>
      </ul>
      @endforeach
    </form>
    @else
    <h3 class="text-center pb-3">コメントはまだありません。</h3>
    @endif
  </div>
@endsection