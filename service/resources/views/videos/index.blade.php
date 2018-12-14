@extends('layouts.app')
@section('title', '首页')

@section('content')

    <div class="row">
        @forelse($rows as $row)
            <div class="col-md-6" id="skeleton">
                <div class="zoom-container">
                    <img class="img-responsive" src="{{$row->cover_url?:'/images/default_cover.jpg'}}"/>
                    <div class="zoom-caption">
                        <span class="tag"></span>
                        <a class="play" href="{{route('video.show', $row->id)}}"><i
                                    class="fa fa-play-circle-o fa-5x" style="color: #fff"></i></a>
                        <p class="video_title"> {{$row->title}} </p>
                    </div>
                </div>
                <div class="video_info">
                    <div class="row">
                        <div class="col-md-6">
                                <span class="updated_at">
                            <i class="fa fa-calendar"></i> {{$row->updated_at}}
                        </span>
                        </div>
                        <div class="col-md-6 text-right">
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
        @empty
            <div class="no_video text-center">
                <img src="/images/no-video.png">
                <p>没有视频</p>
            </div>
        @endforelse
        <div class="col-md-12 text-center">{{$rows->links()}}</div>
    </div>

@endsection