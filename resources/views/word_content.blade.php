@extends('layouts.base')

@section('title', '言葉の詳細ページ')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary">言葉の確認</div>
      <div class="card-body mx-auto">
        <div class="row h5 mb-4">
          <div class="col-sm-3">言葉</div>
          <div class="col-sm-9">{{ $word_content->word }}</div>
        </div>
        <figure class="figure row mb-4">
          <img src="/storage/word_images/{{ $image_name }}" class="figure-img img-fluid">
        </figure>
        <div class="row h5 mb-4">
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
        <div class="row h5 mb-4">
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
        <div class="row h5 mb-4">
          <div class="col-sm-3">メモ</div>
          <div class="col-sm-9">{{ $word_content->memo }}</div>
        </div>
        <div class="row h5 mb-4">
          <div class="col-sm-3">登録日</div>
          <div class="col-sm-9">{{ $word_content->created_at }}</div>
        </div>
        <div class="row h5 mb-4">
          <div class="col-sm-3">更新日</div>
          <div class="col-sm-9">{{ $word_content->updated_at }}</div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <form action="" method="GET">
              <button type="submit" class="btn btn-primary btn-lg">編集する</button>
            </form>
          </div>
          <div class="col-sm-6">
            <form action="" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="word_content" value="{{ $word_content }}">
              <button type="submit" class="btn btn-danger btn-lg">削除する</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <form action="" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <div class="alert alert-danger mt-3" role="alert">
          エラーメッセージ
        </div>
        <label for="comment" class="h5">この言葉にコメント</label>
        <textarea name="comment" id="comment" class="form-control" rows="7">{{old('comment')}}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">コメントする</button>
    </form>

    <h5 class="mt-5">コメント一覧</h5>
    <form action="" method="POST">
      <ul class="list-group">
        <li class="list-group-item mb-5">
          <p>ユーザー名</p>
          <p>コメント内容</p>
          <p>投稿日時：2018/12/08 16:50</p>
          <button type="submit" class="btn btn-danger btn-sm">コメントを削除する</button>
        </li>
      </ul>
    </form>
  </div>
@endsection