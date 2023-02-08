@extends('layouts.login')

@section('content')

<!--検索機能-->
{!! Form::open(['url' => '/search']) !!}
<div id="search">
  <form action="/search" method="GET">
    @csrf
    <input type="text" name="keyword" value="{{ $keyword }}" placeholder="ユーザー名">
    <input type="submit" name="submit" value="検索">
    @if(isset( $keyword ))
    <p>検索ワード：{{$keyword}}</p>
    @else
    @endif
  </form>
</div>
{!! Form::close() !!}

<!--検索結果リスト、フォローボタン-->
<div id="search-list">
  @foreach($users as $user)
  @if(Auth::id() != $user->id)
  <ul>

    <li>
      {{$user -> username}}
      @if (auth()->user()->isFollowing($user->id))
      <form action="{{ route('unfollow', ['id' => $user->id]) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <p class="unfollow-btn"><a href="/search/{{$user->id}}/unfollow">フォロー解除</a>
      </form>

      @else
      <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
        {{ csrf_field() }}

        <p class="follow-btn"><a href="/search/{{$user->id}}/follow">フォローする</a></p>
      </form>
      @endif
    </li>
  </ul>
  @endif
  @endforeach
</div>





@endsection
