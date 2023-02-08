@extends('layouts.login')

@section('content')
{!! Form::open(['url' => '/follower-list']) !!}

<!--フォロワーアイコン-->
@foreach($followed_users as $followed_user)
<!--$userから$followed_userを抽出-->
<div>
  @if($followed_user->images == "dawn.png")
  <img src="/images/icon1.png">
  @else
  <img src=" {{ asset('storage/'.$followed_user->images)}}">
  @endif
</div>
@endforeach

<!--フォロワーリスト-->
@foreach($posts as $post)
</div>
<p>名前：{{ $post->user->username }}</p>
<p>投稿内容：{{ $post->post }}</p>
<p>{{$post->updated_at}}</p>
@endforeach



@endsection

</html>
