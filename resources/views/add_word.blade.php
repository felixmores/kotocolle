@extends('layouts.base')

@section('title', '言葉を登録')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary">新しい言葉を登録する</div>
      <div class="card-body">
        <form action="" method="POST">
          {{ csrf_field() }}
          <div class="form-group row">
            <label for="word" class="col-form-label col-sm-2">言葉</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="word" required autofocus>
            </div>
          </div>
          <div class="form-group row">
            <label for="lank" class="col-form-label col-sm-2">ランク</label>
            <div class="col-sm-10">
              <select class="form-control" id="lank">
                <option>金言</option>
                <option>銀言</option>
                <option>銅言</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="image" class="col-form-label col-sm-2">画像</label>
            <div class="col-sm-10">
              <input type="file" class="form-control-file" id="image">
            </div>
          </div>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0">公開状態</legend>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="share_radios" id="share_on">
                  <label class="form-check-label" for="share_on">公開</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="share_radios" id="share_off" checked>
                  <label class="form-check-label" for="share_off">非公開</label>
                </div>
              </div>
            </div>
          </fieldset>
          <div class="form-group row">
            <div class="row">
              <label for="memo" class="col-form-label col-sm-2">メモ</label>
              <div class="col-sm-10">
                <input type="textarea" class="form-control" id="memo">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary btn-lg">登録</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection