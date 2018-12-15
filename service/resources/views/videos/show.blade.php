@extends('layouts.app')
@section('title', str_limit($row->title))
@section('content')
    <div class="row">
        <div class="col-md-8">
            <h3 class="vid-name">{{$row->title}}</h3>
            <video poster="{{$row->cover_url}}"
                   id="player-container-id" preload="auto"
                   playsinline webkit-playsinline class="img-responsive">
            </video>
            <div class="line"></div>
            <div class="row">
                <div class="col-md-6">
                    <h5>
                        <img src="{{$row->wechat->avatar}}" class="img-circle">
                        <a href="javascript:void(0);" class="followed_number" data-url="{{route('my.followed.store')}}"
                           data-wechat-id="{{$row->wechat->id}}"> 关注 </a></h5>
                </div>
                <div class="col-md-6 text-right">
                    <div class="updated_at"><i class="fa fa-calendar"></i> {{$row->updated_at}} </div>
                    <a href="javascript:void(0)"
                       data-url="{{route("my.liked.store")}}"
                       data-video-id="{{$row->id}}"
                       class="liked_number"><i class="fa fa-heart"></i> {{$row->liked_number?:0}}
                    </a>
                    <span title="{{$row->wechat_number}}">
                        <i class="fa fa-play-circle"></i> {{$row->played_number?:0}}
                    </span>
                </div>
            </div>

            <br>
            <h3>相关视频</h3>
            <div class="row">
                @foreach($related as $row)
                    <div class="col-md-3">
                        <a href="{{route('videos.show', $row->id)}}">
                            <img class="img-responsive" src="{{$row->cover_url?:'/images/default_cover.jpg'}}"/>
                        </a>
                        <p> {{$row->title}} </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection
@section("js")
    <link href="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.css" rel="stylesheet">
    <script src="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var player = TCPlayer('player-container-id', {
                fileID: '{{ $row->file_id }}',
                appID: '{!! config("wechat.cloud.app_id") !!}'
            });
        });
    </script>
@endsection