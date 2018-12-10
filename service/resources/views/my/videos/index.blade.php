@extends('layouts.app')
@section('title', '我的视频')

@section('content')
    <div id="page-content" class="index-page">
        <div class="container">
            <div class="row video_list">
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript">
        var page = 1;

        function ls() {
            $.ajax(
                {
                    url: '/api/my/videos?page=' + page,
                    type: "get",
                    dataType: "json",

                    success: function (res) {
                        var videos = new Array();
                        $.each(res.data.data, function (idx, item) {
                            var template = '<div class="col-md-6">';
                            template += '<div class="zoom-container">';
                            template += '<div class="zoom-caption">';
                            template += '<span>' + item.id + '</span>';
                            template += '<a href="/my/videos/' + item.id + '">';
                            template += '<i class="fa fa-play-circle-o fa-5x" style="color: #fff"></i>';
                            template += '</a>';
                            template += '<p>' + item.title + '</p>';
                            template += '</div>';
                            if (item.cover_url) {
                                template += '<img src="' + item.cover_url + '"/>';
                            }
                            else {
                                template += '<img src="/images/default_cover.jpg" />';
                            }
                            template += '</div>';
                            template += '<h3 class="vid-name"><a href="#">Video\'s Name</a></h3>';
                            template += '</div>';
                            videos.push(template);
                        });
                        console.log(videos.length);
                        if (videos.length > 0) {
                            $('.video_list').append(videos.join(""));
                        }

                    },
                    error: function (res, err, msg) {
                        if (res.status == 401) {
                            alert('加载失败:请重新登录,' + msg);
                        }

                    }
                }
            );
        }

        ls();
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() + 1 >= $(document).height()) {
                page++;
                ls(page);
            }
        });
    </script>
@endsection