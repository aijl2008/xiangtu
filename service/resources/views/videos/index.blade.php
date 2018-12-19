@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="row videos">
        @forelse($rows as $row)
            <div class="col-md-4">
                <!--封面-->
                <a href="{{route('videos.show', $row->id)}}" class="cover">
                    <img
                            class="thumbnail img-responsive img-rounde lazyload cover"
                            src="/images/film.png"
                            data-original="{{$row->cover_url?:''}}">
                </a>
                <span class="tag"></span>
                <div class="title"> {{$row->title}} </div>
                <!--视频信息-->
                <div class="row info">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <img src="/images/user.png" data-original="{{$row->wechat->avatar??''}}" class="img-circle lazyload">
                        <a data-href="" class="follow label label-success">关注</a>
                    </div>
                    <div class="col-md-9  col-sm-9 col-xs-9 text-right">
                        <div class="updated_at"><i class="fa fa-calendar"></i> {{$row->humans_published_at}} </div>
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
        @empty
            <div class="no_video text-center">
                <img src="/images/no-video.png">
                <p>没有视频</p>
            </div>
        @endforelse
        <div class="col-md-12 text-center">{{$rows->links()}}</div>
    </div>
@endsection