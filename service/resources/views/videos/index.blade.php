@extends('layouts.app')
@section('title', '我的视频')

@section('content')
    <div id="page-content" class="index-page">
        <div class="container">
            <div class="row video_list">
                @foreach($rows as $row)
                    <div class="col-md-6" id="skeleton">
                        <div class="zoom-container">
                            <div class="zoom-caption">
                            <span class="tag">
                                <a href="{{route("api.my.liked.store")}}" data-video-id="{{$row->id}}"
                                   class="liked_number"><i
                                            class="fa fa-heart"></i> {{$row->liked_number}} </a>
                            </span>
                                <a class="play" href="{{route('video.show', $row->id)}}"><i class="fa fa-play-circle-o fa-5x" style="color: #fff"></i></a>
                                <p class="title"> {{$row->title}} </p>
                            </div>
                            <img src="{{$row->cover_url?:'/images/default_cover.jpg'}}"/>
                        </div>
                        <div class="info" style="margin: 10px 0px">
                            <span class="updated_at">
                                <i class="fa fa-calendar"></i> {{$row->updated_at}}</span>
                            <a href="javascript:void(0)" data-url="{{route("api.my.liked.store")}}"
                               data-video-id="{{$row->id}}"
                               class="liked_number"><i class="fa fa-heart"></i> {{$row->liked_number}} </a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{$rows->appends(['classification' => $classification])->links()}}
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function () {
            $(".liked_number").click(function () {
                var _this = $(this);
                console.log(_this.data('video-id'));
                $.ajax(
                    {
                        url: _this.data('url'),
                        type: "post",
                        data: {
                            video_id: _this.data('video-id')
                        },
                        dataType: "json",
                        success: function (res) {
                            if (res.code == 0) {
                                __alert("已喜欢");
                                _this.html('<i class="fa fa-heart"></i>' + res.data.liked_number);
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