@extends('layouts.app')
@section('title', str_limit($row->title))
@section('content')


    <div>
        <div class="container">
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
                        <span><i class="fa fa-heart"></i>{{$row->liked_number}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br/>


    <script type="text/javascript">
        var player = TCPlayer('player-container-id', {
            fileID: '{{ $row->file_id }}',
            appID: '{{config("wechat.cloud.app_id")}}'
        });
    </script>
@endsection