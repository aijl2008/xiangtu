@extends('layouts.app')
@section('title', '我的视频')

@section('content')
    <h3><i class="glyphicon glyphicon-hand-right"></i> 我上传的视频</h3>
    <hr/>
    <div class="row videos">
        @forelse($rows as $row)
            <div class="col-md-4">
                <!--封面-->
                <a href="{{route('videos.show', $row->id)}}" class="cover">
                    <img
                            class="thumbnail img-responsive img-rounde lazyload cover"
                            src="/images/loading.png"
                            data-original="{{$row->cover_url?:''}}">
                </a>
                <div class="title text-center"> {{$row->title}} </div>
                <!--视频信息-->
                <div class="row info">
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <span class="updated_at"><i class="fa fa-calendar"></i> {{$row->humans_published_at}} </span>
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

@section('js')
    <script language="JavaScript">
        $(function () {
            $('#my_videos_index').addClass("active")
        });
    </script>
@endsection