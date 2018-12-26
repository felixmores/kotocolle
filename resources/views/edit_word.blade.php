@extends('layouts.base')

@section('title', '言葉を編集')

@section('content')
  <div class="container">
    {{-- カード本体 --}}
    <div class="card mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary mb-0">言葉を編集する</div>
      <div class="card-body border border-top-0 border-primary mb-3">
        {{-- エラーメッセージ --}}
        @if (count($errors) > 0)
        <div class="card-text alert alert-danger" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        {{-- 警告メッセージ --}}
        @php
        $alert_msg = session('alert_msg');
        @endphp
        @isset($alert_msg)
        <div class="card-text alert alert-danger" role="alert">
          {{session('alert_msg')}}
        </div>
        @endisset

        {{-- 送信フォーム --}}
        <form action="{{ action('WordController@word_update', ['user_id' => $edit_content->user_id, 'word_id' => $edit_content->id]) }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}

          {{-- 言葉 --}}
          <div class="form-group row">
            <label for="word" class="col-form-label col-sm-2">言葉</label>
            <div class="col-sm-10">
              <input name="word" type="text" class="form-control" id="word" value="{{ old('word', $edit_content->word) }}" required autofocus>
            </div>
          </div>

          {{-- ランク --}}
          <div class="form-group row">
            <label for="lank" class="col-form-label col-sm-2">ランク</label>
            <div class="col-sm-10">
              <select name="lank" class="form-control w-50" id="lank">
                  @for ($i = 0; $i < 4; $i++)
                    @if (old('lank', $edit_content->lank) == $i)
                      @php
                        $selected = 'selected';
                      @endphp
                    @endif
                    <option value="{{ $i }}" {{ $selected }}>{{ $select_texts[$i] }}</option>
                    @if ($selected == 'selected')
                      @php
                        $selected = '';
                      @endphp
                    @endif
                  @endfor
              </select>
            </div>
          </div>

          {{-- 画像 --}}
          <div class="form-group row">
            <label for="word_image" class="col-form-label col-sm-2">画像</label>
            <div class="input-group col-sm-10">
              <label class="input-group-btn">
                <span class="btn btn-primary">
                  画像を選択
                  <input name="word_image" type="file" class="form-control-file" id="word_image" style="display:none">
                </span>
              </label>
              <input type="text" class="form-control" readonly="" placeholder="※画像を選択しない場合、画像はそのままです。">
            </div>
          </div>

          {{-- 公開状態 --}}
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0">公開状態</legend>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="share_radios" value="1" id="share_on" {{ old('share_radios', $edit_content->share_flag) == 1 ? 'checked' : null}}>
                  <label class="form-check-label" for="share_on">公開</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="share_radios" value="0" id="share_off" {{ old('share_radios', $edit_content->share_flag) == 0 ? 'checked' : null}}>
                  <label class="form-check-label" for="share_off">非公開</label>
                </div>
              </div>
            </div>
          </fieldset>

          {{-- メモ --}}
          <div class="form-group row">
            <label for="memo" class="col-form-label col-sm-2">メモ</label>
            <div class="col-sm-10">
              <textarea name="memo" class="form-control" id="memo" rows="3">{{ old('memo', $edit_content->memo) }}</textarea>
            </div>
          </div>

          {{-- 更新ボタン --}}
          <div class="form-group row">
            <div class="mx-auto">
              <button type="submit" class="btn btn-primary btn-lg px-5">更新</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection