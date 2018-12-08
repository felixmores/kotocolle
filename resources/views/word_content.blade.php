@extends('layouts.base')

@section('title', '言葉の詳細ページ')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary">言葉の確認</div>
      <div class="card-body mx-auto">
        <div class="row h5 mb-4">
          <div class="col-sm-3">言葉</div>
          <div class="col-sm-9">
            ローマは一日にして成らず
          </div>
        </div>
        <div class="row text-center h5 mb-4">
          画像
        </div>
        <div class="row h5 mb-4">
          <div class="col-sm-3">ランク</div>
          <div class="col-sm-3">金言</div>
          <div class="col-sm-3">公開</div>
          <div class="col-sm-3">ON</div>
        </div>
        <div class="row h5 mb-4">
          <div class="col-sm-3">メモ</div>
          <div class="col-sm-9">
            ことわざ辞典を見たときに発見
          </div>
        </div>
        <div class="row h5 mb-4">
          <div class="col-sm-3">登録日</div>
          <div class="col-sm-9">
            2018/12/07 17:43:00
          </div>
        </div>
        <div class="row h5 mb-4">
          <div class="col-sm-3">更新日</div>
          <div class="col-sm-9">
            2018/12/07 17:43:00
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <form action="" method="GET">
              <button type="submit" class="btn btn-primary btn-lg">編集する</button>
            </form>
          </div>
          <div class="col-sm-6">
            <form action="" method="POST">
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
    <ul class="list-group">
      <li class="list-group-item mb-5">
        <p>ユーザー名</p>
        <p>コメント内容</p>
        <p>投稿日時：2018/12/08 16:50</p>
        <form action="" method="POST">
          <button type="submit" class="btn btn-danger btn-sm">コメントを削除する</button>
        </form>
      </li>
    </ul>
  </div>
@endsection