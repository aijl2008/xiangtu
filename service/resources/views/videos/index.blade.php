@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="row">
        @forelse($rows as $row)
            <div class="col-md-6" id="skeleton">
                <!--封面-->
                <div class="zoom-container">
                    <a href="{{route('videos.show', $row->id)}}">
                        <img class="img-responsive img-rounde" src="{{$row->cover_url?:'/images/default_cover.jpg'}}">
                    </a>
                    <div class="zoom-caption">
                        <span class="tag"></span>
                        <a class="play" href="{{route('videos.show', $row->id)}}"><i class="fa fa-play-circle-o fa-5x"
                                                                                     style="color: #fff"></i></a>
                        <p class="video_title"> {{$row->title}} </p>
                    </div>
                </div>


                <!--视频信息-->
                <div class="video_info">

                    <div class="row">
                        <div class="col-md-3">
                            <h5><img src="{{$row->wechat->avatar??''}}" class="avatar img-circle"> 关注 </h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="updated_at"><i class="fa fa-calendar"></i> {{$row->updated_at}} </div>
                            <a href="javascript:void(0)"
                               data-url="{{route("my.liked.store")}}"
                               data-video-id="{{$row->id}}"
                               class="liked_number"><i class="fa fa-heart"></i> {{$row->liked_number?:0}}
                            </a>
                            <span title="{{$row->wechat_number}}">
                                <i class="fa fa-play-circle"></i> {{$row->play_number?:0}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="no_video text-center">
                <img src="/images/no-video.png">
                <p>没有视频</p>
            </div>
        @endforelse
        <div class="col-md-12 text-center">{{$rows->links()}}</div>
    </div>

@endsection