@extends('layouts.app')
@section('title', '我关注的人')
@section('content')

    <div class="row">@foreach($rows as $row)
            <div class="col-md-2">
                <img class="avatar-large" src="{{$row->avatar}}">
                <p>{{$row->nickname}}<a href="javascript:void(0)" data-url="{{route("my.followed.store")}}" class="followed_number"
                       data-wechat-id="{{$row->id}}">
                        <i class="glyphicon glyphicon-eye-open"></i> {{$row->be_followed_number}}
                    </a>
                </p>
            </div>
        @endforeach
    </div>
    <div class="row">
        @foreach($rows as $row)
            @foreach($row->video as $video)
                <div class="col-md-2">
                    <a href="{{route('my.videos.show', $row->id)}}">
                        <img class="img-responsive img-rounde" src="{{$row->cover_url?:'/images/default_cover.jpg'}}">
                    </a>
                    <p> {{$row->title}} </p>
                </div>
            @endforeach
        @endforeach
    </div>

    <div class="line"></div>


@endsection
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#my_followed_index').addClass("active")
        });
    </script>
@endsection