@extends('layouts.app')
@section('title', '我关注的人')
@section('content')
    <h3>我关注的人</h3>
    <hr/>
    <div class="row">@foreach($rows as $row)
            <div class="col-md-2">
                <img class="avatar-large" src="{{$row->avatar}}">
                <p>
                    <span class="label label-info">{{$row->nickname}}</span>
                    <a href="javascript:void(0)"
                       data-url="{{route("my.followed.store")}}"
                       class="followed_number label label-info"
                       data-wechat-id="{{$row->id}}">
                        <i class="glyphicon glyphicon-eye-open"></i> {{$row->be_followed_number}}
                    </a>
                </p>
            </div>
        @endforeach
    </div>
    <h3>我关注的人的视频</h3>
    <hr/>
    <div class="row">
        @foreach($rows as $row)
            @foreach($row->video as $video)
                <div class="col-md-2">
                    <a href="{{route('my.videos.show', $row->id)}}">
                        <img class="img-responsive img-rounde" src="{{$video->cover_url?:'/images/default_cover.jpg'}}">
                    </a>
                    <p> {{$video->title}} </p>
                </div>
            @endforeach
        @endforeach
    </div>

    <h3>推荐关注</h3>
    <hr/>
    <div class="row">
        @foreach($recommended as $row)
            <div class="col-md-2">
                <img class="avatar-large thumbnail" src="{{$row->avatar}}">
                <p class="text-left">
                    <span class="btn btn-sm btn-info">{{$row->nickname}}</span>
                    <a href="javascript:void(0)"
                       data-url="{{route("my.followed.store")}}"
                       class="followed_number btn btn-sm btn-warning"
                       data-wechat-id="{{$row->id}}">
                        关注({{$row->be_followed_number}})
                    </a>
                </p>
            </div>
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