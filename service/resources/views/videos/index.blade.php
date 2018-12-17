@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="row videos">
        @forelse($rows as $row)
            <div class="col-md-3" id="skeleton">
                <!--封面-->
                <a href="{{route('videos.show', $row->id)}}">
                    <img
                            class="img-responsive img-rounde lazyload cover"
                            src="/images/loading/ifeng.jpg"
                            data-original="{{$row->cover_url?:''}}">
                </a>
                <span class="tag"></span>
                <p class="title"> {{$row->title}} </p>
                <!--视频信息-->
                <div class="row">
                    <div class="col-md-3">
                        <h5>
                            <img src="{{$row->wechat->avatar??''}}" class="img-responsive img-circle avatar">
                            <a data-href="" class="follow label label-success">关注</a>
                        </h5>
                    </div>
                    <div class="col-md-9 text-right">
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
        @empty
            <div class="no_video text-center">
                <img src="/images/no-video.png">
                <p>没有视频</p>
            </div>
        @endforelse
        <div class="col-md-12 text-center">{{$rows->links()}}</div>
    </div>
@endsection