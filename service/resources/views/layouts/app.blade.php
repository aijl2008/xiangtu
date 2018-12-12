<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Bearer" content="{{  $Bearer??null }}">
    <title>@yield('title')-乡土味</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->

    <style>

        #main {
            margin-bottom: 100px;
        }

        #navbar {
        }

        .logo {
            display: block;
            padding: 10px 0px;
        }

        .logo span {
            font-size: 24px;
            font-family: "Arial Black";
        }

        .top {
            height: 68px;
        }

        .top ul {
            margin-top: 20px;
        }

        footer {
            margin-top: 200px;
        }

        footer span {
            display: block;
            padding: 20px;
            font-size: 12px;
        }

        .no_video {
            margin: 15px;
        }

        .no_video p {
            font-size: 36px;
        }

        .no_video img {

        }

        .video_title {
            height: 40px;
        }

        .video_info {
            margin: 5px 0px 15px 0px;
        }

        .zoom-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
            font-size: 16px;
            vertical-align: top;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box
        }

        .zoom-container a {
            display: block;
            position: absolute;
            top: -100%;
            opacity: 0;
            left: 0;
            bottom: 0;
            right: 0;
            text-align: center;
            color: inherit
        }

        .zoom-container:hover a {
            opacity: 1;
            top: 0;
            z-index: 500
        }

        .zoom-container:hover a i {
            top: 50%;
            position: absolute;
            left: 0;
            right: 0;
            transform: translateY(-50%)
        }

        .zoom-container img {
            display: block;
            width: 100%;
            height: auto;
            -webkit-transition: all .5s ease;
            -moz-transition: all .5s ease;
            -ms-transition: all .5s ease;
            -o-transition: all .5s ease;
            transition: all .5s ease
        }

        .zoom-container .zoom-caption {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 10;
            -webkit-transition: all .5s ease;
            -moz-transition: all .5s ease;
            -ms-transition: all .5s ease;
            -o-transition: all .5s ease;
            transition: all .5s ease;
            color: #fff
        }

        .zoom-container .zoom-caption span {
            background-color: #fd0005;
            position: absolute;
            top: 0;
            padding: 0 7px;
            font-weight: 700;
            font-size: 13px
        }

        .zoom-container .zoom-caption p {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            background: rgba(0, 0, 0, .5);
            margin: 0;
            padding: 10px
        }

        .zoom-container:hover img {
            -webkit-transform: scale(1.25);
            -moz-transform: scale(1.25);
            -ms-transform: scale(1.25);
            -o-transform: scale(1.25);
            transform: scale(1.25)
        }

        .zoom-container:hover .zoom-caption {
            background: rgba(0, 0, 0, .5)
        }


    </style>
</head>
<body>
<div class="container top">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <a href="/" class="logo">
                <img class="img-rounded" src="/images/logo.jpeg">
                <span>小视频</span>
            </a>
        </div>
        <div class="col-md-6 col-sm-6 text-right">
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
                    <li><i class="fa fa-user"></i> {{ $user->email }}</li>
                    <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out"></i>退出</a></li>
                @elseif($auth == 'guest')
                    <li><a href="/"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="{{ route('wechat.login.redirect') }}"><i class="fa fa-comments"></i> 登录</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">

                @if($auth == 'user')
                    <li><a href="{{ route('admin.classifications.index') }}"><i class="fa fa-cube"></i>视频分类 </a>
                    </li>
                    <li><a href="{{ route('admin.videos.index') }}"><i class="fa fa-film"></i>视频列表 </a>
                    </li>
                    <li><a href="{{ route('admin.users.index') }}"><i class="fa fa-user"></i>用户管理 </a></li>
                @else


                    <li class="@if(!$current)active @endif"><a href="{{ route('home') }}"><i
                                    class="fa fa-home"></i> 全部</a></li>
                    @foreach($navigation as $item)
                        <li class="@if($item->id==$current)active @endif">
                            <a href="{{ route('home',['classification'=>$item->id]) }}"><i
                                        class="fa {{$item->icon}}"></i> {{$item->name}}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</nav>


<div class="container" id="main">
    {{--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">--}}
    {{--Launch demo modal--}}
    {{--</button>--}}
    @yield('content')
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">消息框</h4>
            </div>
            <div class="modal-body">
                <div class="text-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    Enter a valid email address
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">我知道了</button>
            </div>
        </div>
    </div>
</div>

<footer class="footer navbar-fixed-bottom">
    <div class="container">
        <div class="navbar navbar-default">
            <div class="row">
                <div class="col-md-6 col-sm-6 text-center">
                    <span>Copyright &copy; 2019.言诺兰科技</span>
                </div>
                <div class="col-md-6 col-sm-6 text-center">
                    <span>工信部互联网备案编号：冀ICP备18036913号</span>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>