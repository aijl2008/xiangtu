<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')-乡土味</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script src="/jquery/jquery.min.js"></script>
    <script src="/jquery/jquery.lazyload.min.js"></script>
    <script src="/jquery/masonry.pkgd.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootbox.min.js"></script>
    <script src="/js/app.js"></script>
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
    <script>
        if (top.location !== self.location) {
            top.location.href = self.location.href;
        }
        $(function () {
            $("img.lazyload").lazyload();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        });
    </script>
    <style>

    </style>
    @yield('js')
</head>
<body>
<div class="container_box">
    <div id="top" class="container">
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
                        <li><a class="label label-info" href="{{ route('home') }}"><i class="fa fa-home"></i> 首页</a>
                        </li>
                        <li><a class="label label-warning" href="{{ route('wechat.logout') }}"><i
                                        class="fa fa-sign-out"></i>退出</a></li>
                        <li><a class="label label-info" href="{{route('my.videos.index')}}">个人中心</a></li>
                        <img class="avatar" alt="{{$user->name}}"
                             src="{{$user->avatar}}">
                    @elseif($auth == 'user')
                        <li><i class="fa fa-user"></i> {{ $user->email }}</li>
                        <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out"></i>退出</a></li>
                    @elseif($auth == 'guest')
                        <li><a href="/"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{{ route('wechat.login.show') }}"><i class="fa fa-comments"></i> 登录</a></li>
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
                    @if (in_array(Route::currentRouteName(), ['home','videos.index','videos.show','wechat.login.show']) )
                        <li class="@if(!$current)active @endif"><a href="{{ route('home') }}"><i
                                        class="fa fa-home"></i> 全部</a></li>
                        @foreach($navigation as $item)
                            <li class="@if($item->id==($current->id??0))active @endif">
                                <a href="{{ route('home',['classification'=>$item->id]) }}"><i
                                            class="fa {{$item->icon}}"></i> {{$item->name}}</a>
                            </li>
                        @endforeach
                    @else
                        @if($auth == 'user')
                            <li id="admin_classifications_index"><a href="{{ route('admin.classifications.index') }}"><i
                                            class="fa fa-cube"></i>视频分类 </a></li>
                            <li id="admin_logs_index"><a href="{{ route('admin.logs.index') }}"><i
                                            class="fa fa-film"></i>事件管理
                                </a></li>
                            <li id="admin_videos_index"><a href="{{ route('admin.videos.index') }}"><i
                                            class="fa fa-film"></i>视频列表 </a></li>
                            <li id="admin_users_index"><a href="{{ route('admin.users.index') }}"><i
                                            class="fa fa-user"></i>用户管理
                                </a></li>
                        @elseif($auth=='wechat')
                            <li id="my_videos_index">
                                <a href="{{ route('my.videos.index') }}"><i class="fa fa-film"></i>我的视频</a>
                            </li>
                            <li id="my_followed_index">
                                <a href="{{ route('my.followed.index') }}"><i class="fa fa-user"></i>我的关注</a>
                            </li>
                            <li id="my_liked_index">
                                <a href="{{ route('my.liked.index') }}"><i class="fa fa-play-circle-o"></i>我的收藏 </a>
                            </li>
                            <li id="my_statistics_index">
                                <a href="{{ route('my.statistics.index') }}"><i class="fa fa-play-circle-o"></i>数据统计
                                </a>
                            </li>
                            <li id="my_uploader">
                                <a href="{{ route('my.videos.create') }}"><i class="fa fa-cloud-upload"></i>上传视频 </a>
                            </li>
                            <li id="my_uploader">
                                <a href="{{ route('my.profile') }}"><i class="fa fa-cloud-upload"></i>修改资料 </a>
                            </li>
                        @else
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    <div class="container" id="main">
        @yield('content')
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
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

    <div class="clear"></div>
    <div class="container footer_con">
        <div class="row footer">
            <div class="col-md-6 col-sm-6 text-center">
                <span class="copyright">Copyright &copy; 2019.言诺兰科技</span>
            </div>
            <div class="col-md-6 col-sm-6 text-center">
                <span class="icp">工信部互联网备案编号：冀ICP备18036913号</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>