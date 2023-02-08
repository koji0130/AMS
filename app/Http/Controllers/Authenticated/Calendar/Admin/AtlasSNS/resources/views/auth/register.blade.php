@extends('layouts.logout')

@section('content')

{!! Form::open(['url' => '/register']) !!}
@foreach ($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

<h2>新規ユーザー登録</h2>

<div class="ct-block">
  <label class="contact-text" for="name">{{ Form::label('ユーザー名') }}</label>
  {{ Form::text('username',null,['class' => 'input', 'placeholder' => 'admin']) }}
</div>

<div class="ct-block">
  <label class="contact-text" for="name">{{ Form::label('メールアドレス') }}</label>
  {{ Form::text('mail',null,['class' => 'input', 'placeholder' => 'xxx@atlas.com']) }}
</div>

<div class="ct-block">
  <label class="contact-text" for="name"> {{ Form::label('パスワード') }}</label>
  {{ Form::text('password',null,['class' => 'input']) }}
</div>

<div class="ct-block">
  <label class="contact-text" for="name">{{ Form::label('パスワード確認') }}</label>
  {{ Form::text('password_confirmation',null,['class' => 'input']) }}
</div>

{{ Form::submit('登録',['class' => 'button']) }}

<p class="back"><a href="/login">ログイン画面へ戻る</a></p>

{!! Form::close() !!}


@endsection
