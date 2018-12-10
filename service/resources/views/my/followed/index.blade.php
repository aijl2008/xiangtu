@extends('layouts.app')
@section('title', '我关注的视频')
@section('content')
    <div id="page-content" class="index-page">
        <div class="container">
            @foreach($rows as $row)
                <div class="box">
                    <div>
                        <img src="{{$row->avatar}}">
                        <p>{{$row->nickname}}</p>
                        <a href="javascript:void(0)" data-url="{{route("api.my.followed.store")}}" class="be_followed"
                           data-wechat-id="{{$row->id}}"><i
                                    class="glyphicon glyphicon-eye-open"></i> {{$row->be_followed_number}}</a>
                    </div>
                    <div class="box-content">
                        <div class="row">

                            @foreach($row->video as $video)
                                <div class="col-md-3">
                                    <div class="wrap-vid">
                                        <div class="zoom-container">
                                            <div class="zoom-caption">
                                                <span>Video's Tag</span>
                                                <a href="{{route('video.show', $video->id)}}">
                                                    <i class="fa fa-play-circle-o fa-5x" style="color: #fff"></i>
                                                </a>
                                                <p class="title">{{$video->title}}</p>
                                            </div>
                                            <img src="{{$video->cover_url}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="line"></div>
                </div>
            @endforeach
        </div>
    </div>
@endsection



@section('js')
    <script type="text/javascript">
        $(function () {
            $(".be_followed").click(function () {
                var _this = $(this);
                console.log(_this.data('wechat-id'));
                $.ajax(
                    {
                        url: _this.data('url'),
                        type: "post",
                        data: {
                            wechat_id: _this.data('wechat-id'),
                            __method:'DELETE'
                        },
                        dataType: "json",
                        success: function (res) {
                            if (res.code == 0) {
                                __alert("已关注");
                                _this.html('<i class="fa fa-heart"></i>' + res.data.followed_number);
                            }
                            else {
                                __alert(res.msg);
                            }
                        },
                        error: function (res, err, msg) {
                            if (res.status == 401) {
                                __alert("请登录");
                            }
                            else {
                                __alert(msg);
                            }
                        }
                    }
                );
            });
        });
    </script>
@endsection