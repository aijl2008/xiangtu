@extends('layouts.app')
@section('title', '我的视频')

@section('content')
    <h3 class="red"><i class="glyphicon glyphicon-hand-right"></i> 我上传的视频</h3>
    <hr/>
    <div class="row my-videos">
        @forelse($rows as $row)
            <div class="col-md-4">
                <a href="{{route('videos.show', $row->id)}}" class="cover">
                    <img
                            class="thumbnail img-responsive img-rounde lazyload cover"
                            src="/images/loading/video.png"
                            data-original="{{$row->cover_url?:''}}">
                </a>
                <div class="my-videos">
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
                <div class="title text-center"> {{$row->title}} </div>
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

@section('js')
    <script language="JavaScript">
        $(function () {
            $('#my_videos_index').addClass("active")
        });
    </script>
@endsection