@extends('layouts.app')
@section('title', '我关注的人')
@section('content')
    @if (count($rows)>0)
        <h3><i class="glyphicon glyphicon-hand-right"></i> 我关注的人</h3>
        <hr/>
        <div class="row">@foreach($rows as $row)
                <div class="col-lg-2 col-md-4 col-sm-8 col-xs-12 my-followed">
                    <img class="lazyload img-responsive" src="/images/user-160.png"
                         data-original="{{$row->avatar}}">
                    <p class="text-center">
                        <span class="label label-info">{{$row->nickname}}</span>
                        <span class="label label-info"><i class="glyphicon glyphicon-film"></i> {{$row->video->count()}}</span>
                        <a href="javascript:void(0)"
                           data-url="{{route("my.followed.store")}}"
                           data-reload="1"
                           class="followed_number label label-danger"
                           data-wechat-id="{{$row->id}}">
                            <i class="fa fa-eye-slash"></i>
                        </a>
                    </p>
                </div>
            @endforeach
        </div>
        <h3><i class="glyphicon glyphicon-hand-right"></i> 我关注的人的视频</h3>
        <hr/>
        <div class="row">
            @foreach($rows as $row)
                @foreach($row->video as $video)
                    <div class="col-lg-2 col-md-4 col-sm-8 col-xs-12">

                        <a href="{{route('videos.show', $video->id)}}" class="cover">
                            <img
                                    class="thumbnail img-responsive img-rounde lazyload cover"
                                    src="/images/loading.png"
                                    data-original="{{$video->cover_url?:''}}">
                        </a>
                        <div class="title text-center"> {{$video->title}} </div>


                    </div>
                @endforeach
            @endforeach
        </div>
    @endif
    <h3><i class="glyphicon glyphicon-hand-right"></i> 推荐关注</h3>
    <hr/>
    <div class="row">
        @foreach($recommended as $row)
            <div class="col-lg-2 col-md-4 col-sm-8 col-xs-12 ">
                <img class="lazyload img-responsive img-circle" src="/images/user-160.png"
                     data-original="{{$row->avatar}}">
                <p class="text-center">
                    <span class="label label-info">{{$row->nickname}}</span>
                    <a href="javascript:void(0)"
                       data-url="{{route("my.followed.store")}}"
                       data-reload="1"
                       class="followed_number label label-warning"
                       data-wechat-id="{{$row->id}}">
                        {{$row->be_followed_number}} 人关注他
                    </a>
                </p>
            </div>
        @endforeach
    </div>
    <div class="line"></div>


@endsection
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#my_followed_index').addClass("active")
        });
    </script>
@endsection