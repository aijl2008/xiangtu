@extends('layouts.app')
@section('title', str_limit($row->title))
@section('content')


    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <video poster="{{$row->cover_url}}" id="player-container-id" preload="auto" width="720" height="405"
                           playsinline webkit-playsinline> playsinline webkit-playsinline>
                    </video>
                    <h1 class="vid-name"><a href="#">{{$row->title}}</a></h1>
                    <div class="line"></div>
                    <div class="info">
                        <h5>由 <a href="#">{{$row->wechat->nickname}}</a> 上传</h5>
                        <span><i class="fa fa-calendar"></i>{{$row->uploaded_at}}</span>
                        <a title="{{$row->liked_number}}" href="javascript:void(0)"
                           data-url="{{route("my.liked.store")}}"
                           data-video-id="{{$row->id}}"
                           class="liked_number"><i class="fa fa-heart"></i>
                        </a>
                        <span title="{{$row->wechat_number}}"><i class="fa fa-heart"></i></span>
                        <span title="{{$row->moment_number}}"><i class="fa fa-heart"></i> </span>
                        <span title="{{$row->play_number}}"><i class="fa fa-heart"></i> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br/>



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