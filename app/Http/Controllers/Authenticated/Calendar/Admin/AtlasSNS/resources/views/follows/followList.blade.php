  @extends('layouts.login')


  <div class="follows-container">

    @section('content')

    {!! Form::open(['url' => '/follow-list']) !!}


    <!--フォローアイコン-->
    <div class="follow-iconlist">
      <h1 class="">Follow list</h1>
      <div class="follow-iconbox">
        @foreach($following_users as $following_user)
        <!--$userから$follow_userを抽出-->
        @if($following_user->images == "dawn.png")
        <img src="/images/icon1.png" width="50" height="50">
        @else
        <img src=" {{ asset('storage/'.$following_user->images)}}" width="70" height="70">
        @endif
        @endforeach
      </div>
    </div>

    <!--フォローリスト-->
    @foreach($posts as $post)
    <!--$postsから$postを抽出-->


    <div class="follow">
      <p></p>
      <p>{{ $post->user->username }}</p>
      <p>{{ $post->post }}</p>
      <p>{{$post->updated_at}}</p>
      @endforeach
    </div>
    @endsection



    </html>
