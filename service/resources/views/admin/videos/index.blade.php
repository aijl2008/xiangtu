@extends('layouts.app')
@section('title', '全部视频')
@section('content')
    <div id="page-content" class="index-page">
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>标题</th>
                        <th>封面</th>
                        <th>播放次数</th>
                        <th>喜欢人数</th>
                        <th>分享给好友次数</th>
                        <th>分享到朋友圈次数</th>
                        <th>可见范围</th>
                        <th>上传时间</th>
                    </tr>
                    @foreach($rows as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td></td>
                            <td style="width: 100px">
                                @if ($row->cover_url)
                                    <img class="thumbnail" src="{{$row->cover_url}}">
                                @endif
                                <a href="{{route('admin.videos.show', $row->id)}}">{{$row->title}}</a>
                            </td>
                            <td>{{$row->played_number}}</td>
                            <td>{{$row->liked_number}}</td>
                            <td>{{$row->shared_wechat_number}}</td>
                            <td>{{$row->shared_moment_number}}</td>
                            <th>visibility</th>
                            <td>{{$row->created_at}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>


            <div class="row">
                <div class="featured">
                    <div class="main-vid">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection