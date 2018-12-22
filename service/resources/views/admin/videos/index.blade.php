@extends('layouts.app')
@section('title', '全部视频')
@section('content')
    <h3>视频管理</h3>
    <hr>
    <div class="rows video-admin">
        @foreach($rows as $row)
            <div class="col-md-3">
                <a href="{{route('admin.videos.show', $row->id)}}">
                    <img
                            class="thumbnail img-responsive lazyload cover"
                            src="/images/loading/video.png"
                            data-original="{{$row->cover_url?:''}}">
                </a>
                <div class="text-nowrap title">{{$row->title}}</div>
                <dl class="dl-horizontal">
                    <dt>分类</dt>
                    <dd class="text-nowrap">{{$row->classification->name}}</dd>
                    <dt>播放与收藏</dt>
                    <dd class="text-nowrap">{{$row->formatted_played_number}}/{{$row->formatted_liked_number}}</dd>
                    <dt>可见范围</dt>
                    <dd class="text-nowrap">{{$row->visibility}}</dd>
                    <dt>发布时间</dt>
                    <dd class="text-nowrap">{{$row->created_at}}</dd>
                    <dt>发布人</dt>
                    <dd class="text-nowrap">{{$row->wechat->nickname}}</dd>
                </dl>
            </div>
        @endforeach
    </div>
    <div class="text-center">{{$rows->links()}}</div>
    <div class="clearfix"></div>
@endsection

@section('js')
    <script language="JavaScript">
        $(function () {
            $('#admin_videos_index').addClass("active")
        });
    </script>
@endsection