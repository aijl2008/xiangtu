@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="row videos">
        @forelse($rows as $row)
            <div class="col-md-4">
                <a href="{{route('videos.show', $row->id)}}" class="cover">
                    <img
                            class="thumbnail img-responsive img-rounde lazyload cover"
                            src="/images/loading/video.png"
                            data-original="{{$row->cover_url?:''}}">
                </a>
                <div class="title text-center"> {{$row->title}} </div>
                <div class="avatar-container">
                    <img src="/images/user-48.png"
                         data-original="{{$row->wechat->avatar??''}}"
                         class="img-circle lazyload avatar-middle">
                    <a
                            href="javascript:void(0);"
                            class="follow followed_number label label-default"
                            data-url="{{ route('my.followed.store') }}"
                            data-wechat-id="{{$row->wechat->id}}">关注</a>
                </div>
                <div class="video-info-container">
                    <div class="updated_at"><i class="fa fa-calendar"></i> {{$row->humans_published_at}} </div>
                    <a href="javascript:void(0)"
                       data-url="{{route("my.liked.store")}}"
                       data-video-id="{{$row->id}}"
                       class="liked_number"><i class="fa fa-heart"></i> {{$row->liked_number?:0}}
                    </a>
                    <span class="played_number" title="{{$row->wechat_number}}">
                                <i class="fa fa-play-circle"></i> {{$row->play_number?:0}}
                            </span>
                </div>
                <div class="clearfix"></div>
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