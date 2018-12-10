@extends('layouts.app')

@section('content')


    <div id="page-content" class="single-page">
        <div class="container">
            <div class="row">
                <div id="main-content" class="col-md-8">
                    <form class="form-horizontal" id="form">
                        <p class="center">
                            <a href="###"><img class="img-rounded" src="{{$user->avatar}}"></a>
                        </p>
                        <div class="center">
                            <input type="text" name="name" id="name" value="{{$user->name}}">
                            <input type="text" name="avatar" id="avatar" class="form-control">
                            <button id="submit" type="button" class="btn btn-primary">保存修改</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form id="uploadForm" enctype="multipart/form-data" style="display: none;">
        <input type="email" name="email" value="awz@awz.cn">
        <input type="file" name="upload_avatar" id="upload_avatar">
    </form>
@endsection
@section('js')
    <script>
        $(function () {
            $("#submit").on("click", function () {
                if (!$("#avatar").val()) {
                    alert("请选择图片");
                    return;
                }
                $.ajax({
                    url: '{{route("api.my.profile.update")}}',
                    type: 'PATCH',
                    data: $("#form").serialize(),
                    dataType: 'json',
                    success: function (res) {
                        if ("undefined" == res.code) {
                            alert("无法解析接口状态");
                            return;
                        }
                        if (res.code == 0) {
                            alert("修改成功");
                            window.location.reload();
                        }
                        else {
                            if (res.msg) {
                                alert("修改失败," + res.msg);
                            }
                            else {
                                alert("修改失败");
                            }
                        }
                    },
                    error: function (res, err) {
                        alert('修改失败:' + err);
                    }
                });
            });
            $('#upload_avatar').on('change', function () {
                var upload_avatar = $("#upload_avatar").val();
                if(upload_avatar){
                    $.ajax({
                        url:'/my/profile/upload',
                        type:'POST',
                        dataType: 'json',
                        data:(new FormData(document.getElementById('uploadForm'))),
                        async: false,
                        cache: false,
                        contentType: false, //不设置内容类型
                        processData: false, //不处理数据
                        success: function (res) {
                            if ("undefined" == res.code) {
                                alert("无法解析图片上传状态");
                                return;
                            }
                            if (res.code != 0) {
                                alert("图片上传失败," + res.msg);
                                return;
                            }
                            $("#avatar").val(res.data.url);
                        },
                        error: function (res, err) {
                            alert('图片上传失败:' + err);
                        }
                    })
                }else {
                    alert("选择的文件无效！请重新选择");
                }
            });
            $('.img-rounded').on('click', function () {
                $('#upload_avatar').click();
            });
        });
    </script>

@endsection