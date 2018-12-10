@extends('layouts.app')
@section('title', '微信登录')

@section('content')
    <div class="container">
        <div class="center">
            <div class="row">

                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div id="login_container"></div>
                    <a href="{{route('wechat.login.redirect')}}" class="btn btn-primary">点此使用微信登录</a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="//res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
    <script type="text/javascript">
        var obj = new WxLogin({
            self_redirect:true,
            id:"login_container",
            appid: "",
            scope: "snsapi_login",
            redirect_uri: "{{route('wechat.login.do')}}",
            state: "",
            style: "",
            href: ""
        });
    </script>
@endsection

