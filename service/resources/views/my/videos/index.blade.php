@extends('layouts.app')
@section('title', '我的视频')

@section('content')
    <h3>我上传的视频</h3>
    <hr/>
    <div class="row">
        @forelse($rows as $row)
            <div class="col-md-4" id="skeleton">
                <!--封面-->
                <a href="{{route('my.videos.show', $row->id)}}">
                    <img class="img-responsive img-rounde" src="{{$row->cover_url?:'/images/default_cover.jpg'}}">
                </a>
                <p> {{$row->title}} </p>
                <!--视频信息-->
                <div class="row">
                    <div class="col-md-12">
                        <span><i class="fa fa-calendar"></i> {{$row->updated_at}}</span>
                        <span>
                                <i class="fa fa-heart"></i> {{$row->liked_number?:0}}
                            </span>
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