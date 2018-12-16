@extends('layouts.app')
@section('title', str_limit($row->title))
@section('content')
    <div class="row">
        <div class="col-md-8 videos">
            <h3 class="vid-name">{{$row->title}}</h3>
            <hr/>
            <div id="video_container"></div>
            <div class="row">
                <div class="col-md-6">
                    <h5>
                        <img src="{{$row->wechat->avatar}}" class="img-circle">
                        <a
                                href="javascript:void(0);"
                                class="follow followed_number btn-sm btn-warning"
                                data-url="{{route('my.followed.store')}}"
                                data-wechat-id="{{$row->wechat->id}}">关注 </a></h5>
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
                            <img class="img-responsive lazyload"
                                 data-original="{{$row->cover_url}}"
                                 src="/images/loading/ifeng.jpg"
                            />
                        </a>
                        <p> {{$row->title}} </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script src="//qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js" charset="utf-8"></script>
    <script type="text/javascript">
        $(function () {
            var listener = {
                playStatus: function (status) {
                    if (status == 'playing') {
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
                    }
                    console.log(status);
                }
            };
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
            var player = new qcVideo.Player(
                "video_container",
                option,
                listener
            );
            player.resize(300, 200);
        });
    </script>
@endsection