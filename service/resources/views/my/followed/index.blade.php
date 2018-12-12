@extends('layouts.app')
@section('title', '我关注的人')
@section('content')
    <div id="page-content" class="index-page">
        <div class="container">
            @foreach($rows as $row)
                <div class="box">
                    <div>
                        <img src="{{$row->avatar}}">
                        <p>{{$row->nickname}}</p>
                        <a href="javascript:void(0)" data-url="{{route("api.my.followed.store")}}" class="be_followed"
                           data-wechat-id="{{$row->id}}"><i
                                    class="glyphicon glyphicon-eye-open"></i> {{$row->be_followed_number}}</a>
                    </div>
                    <div class="box-content">
                        <div class="row">

                            @foreach($row->video as $video)
                                <div class="col-md-3">
                                    <div class="wrap-vid">
                                        <div class="zoom-container">
                                            <div class="zoom-caption">
                                                <span>Video's Tag</span>
                                                <a href="{{route('video.show', $video->id)}}">
                                                    <i class="fa fa-play-circle-o fa-5x" style="color: #fff"></i>
                                                </a>
                                                <p class="title">{{$video->title}}</p>
                                            </div>
                                            <img src="{{$video->cover_url}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="line"></div>
                </div>
            @endforeach
        </div>
    </div>
@endsection