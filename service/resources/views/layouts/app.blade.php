<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Bearer" content="{{  $Bearer??null }}">
    <title>@yield('title')-乡土味</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.css" rel="stylesheet">
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.js"></script>
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="//imgcache.qq.com/open/qcloud/video/tcplayer/lib/hls.min.0.8.8.js"></script>
    <script src="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/social-share.min.js"></script>
    <script language="JavaScript">
        $.ajaxSetup({
            beforeSend: function (xhr, settings) {
                var Bearer = "Bearer " + $('meta[name="Bearer"]').attr('content')
                xhr.setRequestHeader("Authorization", Bearer);
            }
        });

        function __alert(message) {
            $('#message-error').modal("show");
            $('#message-error').find(".message").html(message);
        }
    </script>
    <style>
        .vertical {
            vertical-align: middle;
        }

        html, body {
            height: 100%;
            margin: 0;
        }

        .wrapper {
            min-height: 100%;

            /* Equal to height of footer */
            /* But also accounting for potential margin-bottom of last child */
            margin-bottom: -50px;
        }

        .footer,
        .push {
            height: 50px;
        }
    </style>
    @yield('js')
</head>
<body>
<header>
    <nav id="top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6" style=" padding-bottom: 10px">
                    <a href="/"><img class="img-rounded" style="width: 50px;"
                                     src="/images/logo.png"></a>
                    <strong style="font-size: 26px; padding-top: 24px; padding-left: 10px">视频</strong>
                </div>
                <div class="col-md-6 col-sm-6">
                    <ul class="list-inline top-link link">
                        @if ($auth == 'wechat')
                            <li><a href="{{ route('my.followed.index') }}"><i class="fa fa-user"></i>关注</a></li>
                            <li><a href="{{ route('my.liked.index') }}"><i class="fa fa-play-circle-o"></i>喜欢</a>
                            </li>
                            <li><a href="{{ route('my.videos.create') }}"><i class="fa fa-cloud-upload"></i>上传</a></li>
                            </li>
                            <li><a href="{{ route('wechat.logout') }}"><i class="fa fa-sign-out"></i>退出</a></li>
                            <a href="{{route('my.videos.index')}}"><img alt="{{$user->name}}" style="width: 32px"
                                                                        src="{{$user->avatar}}"></a>
                        @elseif($auth == 'user')
                            <li><a href="/"><i class="fa fa-home"></i>首页</a></li>
                            <li><a href="{{ route('admin.classifications.index') }}"><i class="fa fa-cube"></i>分类 </a>
                            </li>
                            <li><a href="{{ route('admin.videos.index') }}"><i class="fa fa-film"></i>视频 </a>
                            </li>
                            <li><a href="{{ route('admin.users.index') }}"><i class="fa fa-user"></i>用户 </a></li>
                            <li>{{ $user->name }}</li>
                            <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out"></i>退出</a></li>
                        @elseif($auth == 'guest')
                            <li><a href="/"><i class="fa fa-home"></i>首页</a></li>
                            <li><a href="{{ route('wechat.login.redirect') }}"><i class="fa fa-comments"></i>登录</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <nav id="menu" class="navbar">
        <div class="container">
            <div class="navbar-header"><span id="heading" class="visible-xs"></span>
                <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse"
                        data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> 全部</a></li>
                    @foreach($classifications as $classification)
                        <li>
                            <a href="{{ route('home',['classification'=>$classification->id]) }}"><i
                                        class="fa {{$classification->icon}}"></i> {{$classification->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

</header>
<div class="content">
    @yield('content')
</div>
<footer style="height: 40px;">
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 copyright">
                    <span>Copyright &copy; 2019.言诺兰科技</span>
                </div>
                <div class="col-md-6 col-sm-6 link">
                    <span>工信部互联网备案编号：冀ICP备18036913号</span>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="message-error" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="alert alert-warning message" role="alert"></div>
        </div>
    </div>
</div>
</body>
</html>
