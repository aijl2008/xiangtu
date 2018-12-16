@extends('layouts.app')
@section('title', '微信登录')

@section('content')
    <div class="row login">
        <div class="col-md-8">
            <div class="row recommend">
                @foreach($rows as $row)
                    <div class="col-md-3">
                        <a href="{{route('wechat.login.mock', $row->id)}}"><img style="width: 132px"
                                                                                src="{{$row->avatar}}"
                                                                                class="img-responsive img-circle"></a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <div id="login_container"></div>
        </div>
    </div>
@endsection

@section('js')
    <script src="//res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
    <script type="text/javascript">
        $(function () {
            var obj = new WxLogin({
                self_redirect: false,
                id: "login_container",
                appid: "{{config('wechat.open_platform.default.app_id')}}",
                scope: "snsapi_login",
                redirect_uri: "{{route('wechat.login.do')}}",
                state: "{{ csrf_token() }}",
                style: "",
                href: ""
            });
        });
    </script>
@endsection

