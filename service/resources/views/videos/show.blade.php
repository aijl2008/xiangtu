@extends('layouts.app')
@section('title', str_limit($row->title))
@section('content')
    <div class="row">
        <div class="col-md-8 video">
            <h3 class="vid-name">{{$row->title}}</h3>
            <hr/>
            <video class="img-responsive" id="player-container-id" width="800" height="480" preload="auto" playsinline
                   webkit-playsinline>
            </video>
            <div class="row">
                <div class="col-md-3 avatar">
                    <img src="/images/user-48.png"
                         data-original="{{$row->wechat->avatar}}"
                         class="img-responsive avatar-for-show lazyload img-circle">
                    <a
                            href="javascript:void(0);"
                            class="follow followed_number btn-sm btn-warning"
                            data-url="{{route('my.followed.store')}}"
                            data-wechat-id="{{$row->wechat->id}}">关注 </a>
                </div>
                <div class="col-md-9 text-right">
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
            <div class="tip"><img src="/images/wifi-signal-24.png"> <strong>相关视频</strong></div>
            <div class="row">
                @foreach($related as $row)
                    <div class="col-md-3 related">
                        <a href="{{route('videos.show', $row->id)}}" class="cover">
                            <img
                                    class="thumbnail img-responsive img-rounde lazyload cover"
                                    src="/images/loading.png"
                                    data-original="{{$row->cover_url?:''}}">
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
            var option = {
                "cover": "{{$row->cover_url}}",
                "file_id": "{{$row->file_id}}",
                "app_id": "{{config('wechat.cloud.app_id')}}",
                "third_video":
                    {
                        "urls":
                            {
                                20:
                                    "{{$row->url}}"
                            }
                    }
            };
            // option = {
            //     fileID: '7447398157015849771', // 请传入需要播放的视频filID 必须
            //     appID: '1256993030' // 请传入点播账号的appID 必须
            // };
            var player = new TCPlayer(
                "player-container-id",
                option
            );
            player.on("play", function () {
                $.ajax(
                    {
                        url: "{{route('videos.play', $row->id)}}",
                        type: "post",
                        dataType: "json",
                        success: function (res) {
                            console.log(res);
                        },
                        error: function (res, err, msg) {
                            console.log(res, err, msg);
                        }
                    }
                );
            });
            player.on("ready", function () {
                // var width =  $('.videos').width();
                // var height = width *2 /3;
                // player.width(width);
                // player.height(height);
            });
        });
    </script>
@endsection