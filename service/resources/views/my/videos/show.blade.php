@extends('layouts.app')
@section('title', str_limit($row->title))
@section('content')
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <img class="img-responsive" src="{{$row->cover_url?:'/images/default_cover.jpg'}}"/>
                    <h3 class="vid-name">{{$row->title}}</h3>
                    <div class="line"></div>
                    <div class="info">
                        <h5><img src="{{$row->wechat->avatar}}"> 由 <a href="#">{{$row->wechat->nickname}}</a> 上传</h5>
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
                    <h3>他们也收藏了这些视频</h3>

                    <div class="row">
                        @foreach($row->liker()->take(10)->get() as $item)
                            <div class="col-md-2">
                                <img src="{{$item->avatar}}" class="img-responsive img-circle">
                                <p><a data-url="{{route("my.followed.store")}}"
                                      data-video-id="{{$row->id}}"
                                      class="followed_number">关注他</a></p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    @foreach($related as $row)
                        <div class="col-md-12">
                            <a class="play" href="{{route('my.videos.show', $row->id)}}">
                                <img class="img-responsive" src="{{$row->cover_url?:'/images/default_cover.jpg'}}"/>
                            </a>
                            <p> {{$row->title}} </p>
                        </div>
                    @endforeach
                </div>
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