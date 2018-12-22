@extends('layouts.app')
@section('title', str_limit($row->title))
@section('content')
    <h3>视频管理</h3>
    <div class="row">
        <div class="col-md-8">
            <video poster="{{$row->cover_url}}" id="player-container-id" preload="auto" width="720" height="405"
                   playsinline webkit-playsinline> playsinline webkit-playsinline>
            </video>
            <h1 class="vid-name"><a href="#">{{$row->title}}</a></h1>
            <div class="line"></div>
            <div class="info">
                <h5>By <a href="#">Kelvin</a></h5>
                <span><i class="fa fa-calendar"></i>{{$row->uploaded_at}}</span>
                <span><i class="fa fa-heart"></i>{{$row->formatted_liked_number}}</span>
            </div>
            <div class="line"></div>
            <div class="info">
                <h5>时长： {{$video->basicInfo->duration}}</h5>
                <h5>文件大小： {{$video->basicInfo->totalSize}}</h5>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#admin_videos_index').addClass("active");
            var player = TCPlayer('player-container-id', {
                fileID: '{{ $row->file_id }}',
                appID: '{{config("wechat.cloud.app_id")}}'
            });
        });
    </script>
@endsection