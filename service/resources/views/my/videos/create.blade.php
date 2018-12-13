@extends('layouts.app')

@section('content')
    <form id="form">
        <div class="form-group">
            <label class="col-md-2 control-label text-right">选择视频</label>
            <div class="col-md-10">
                <input class="form-control" type="text" value="" name="url" id="url" readonly="readonly">
                <input type="hidden" value="" name="file_id" id="file_id">
                <p class="form-control-static" id="queue_videos"><a id="addVideo"
                                                                    href="javascript:void(0);"
                                                                    class="btn btn-info">添加视频</a></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label text-right">选择视频封面</label>
            <div class="col-md-10">
                <input class="form-control" type="text" value="" name="cover_url" id="cover_url" readonly="readonly">
                <p class="form-control-static" id="queue_video_covers"><a id="addCover"
                                                                          href="javascript:void(0);"
                                                                          class="btn btn-info">添加封面</a>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-md-2 control-label text-right">视频名称</label>
            <div class="col-md-10">
                <input class="form-control" type="text" name="title" id="title" required="">
            </div>
        </div>
        <div class="form-group {{ $errors->has('classification_id') ? 'has-error' : ''}}">
            {!! Form::label('classification_id', '分类', ['class' => 'col-md-2 control-label text-right']) !!}
            <div class="col-md-10">
                @foreach($navigation as $item)
                    <div class="radio">
                        <label>
                            {!! Form::radio('classification_id', $item->id); !!}
                            {{$item->name}}
                        </label>
                    </div>
                @endforeach
                {!! $errors->first('classification_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label text-right">谁可以看</label>
            <div class="col-md-10">
                <div class="radio">
                    <label>
                        <input type="radio" name="visibility" id="optionsRadios1" value="1">
                        任何人都可以看
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="visibility" id="optionsRadios2" value="2">
                        关注我的人可以看
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="visibility" id="optionsRadios3" value="3">
                        只有我自己可以看
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <a id="uploadFile" href="javascript:void(0);" class="btn btn-primary">上传并保存</a>
                </div>
            </div>
        </div>
    </form>
    <div style="display: none">
        <input type="file" id="addVideo-file">
        <input type="file" id="addCover-file">
    </div>
    <div class="modal fade" id="loadingModal">
        <div style="width: 200px;height:20px; z-index: 20000; position: absolute; text-align: center; left: 50%; top: 50%;margin-left:-100px;margin-top:-10px">
            <div class="progress progress-striped active" style="margin-bottom: 0;">
                <div class="progress-bar" style="width: 100%;"></div>
            </div>
            <h5>正在加载...</h5>
        </div>
    </div>
@endsection
@section('js')
    <script src="//imgcache.qq.com/open/qcloud/js/vod/sdk/ugcUploader.js"></script>
    <script type="text/javascript">

        $(function () {

            /**
             * 用于实现取消上传的两个对象。需要在 progress 回调中赋值。
             */
            var uploadCos;
            var uploadTaskId;

            var index = 0;
            var cosBox = [];
            /**
             * 计算签名
             */
            var getSignature = function (callback) {
                $.ajax({
                    url: '{{route("my.qcloud.signature.vod")}}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.data && res.data.signature) {
                            callback(res.data.signature);
                        } else {
                            bootbox.alert({
                                title: "上传错误",
                                message: "获取签名失败",
                                className: 'bb-alternate-modal'
                            });
                            return;
                        }
                    },
                    error: function (res, err) {
                        bootbox.alert({
                            title: "上传错误",
                            message: '获取签名失败:' + err,
                            className: 'bb-alternate-modal'
                        });
                        return;
                    }
                });
            };

            var videoFileList = [];
            var coverFileList = [];
            // 给addVideo添加监听事件
            $('#addVideo-file').on('change', function (e) {
                var videoFile = this.files[0];
                videoFileList[0] = videoFile;
                $('#queue_videos').html(videoFile.name);
                $("#title").val(videoFile.name);

            });
            $('#addVideo').on('click', function () {
                $('#addVideo-file').click();
            });
            // 给addCover添加监听事件
            $('#addCover-file').on('change', function (e) {
                var coverFile = this.files[0];
                coverFileList[0] = coverFile;
                $('#queue_video_covers').html(coverFile.name);

            });
            $('#addCover').on('click', function () {
                $('#addCover-file').click();
            });

            var startUploader = function () {
                bootbox.alert({
                    title: "正在上传，请不要关闭当前页",
                    message: "<div class=\"progress\">\n" +
                    "    <div class=\"progress-bar\" style=\"width: 0%;\">\n" +
                    "        <span class=\"sr-only\">0% Complete</span>\n" +
                    "    </div>\n" +
                    "</div>",
                    callback: function () {

                        $('#resultBox').on('click', '[act=cancel-upload]', function () {
                            var cancelresult = qcVideo.ugcUploader.cancel({
                                cos: cosBox[$(this).attr('cosnum')],
                                taskId: $(this).attr('taskId')
                            });
                            console.log(cancelresult);
                        });
                        console.log('This was logged in the callback!');
                    }
                });
                var resultMsg = qcVideo.ugcUploader.start({
                    videoFile: videoFileList[0],
                    coverFile: coverFileList[0],
                    getSignature: getSignature,
                    allowAudio: 1,
                    success: function (result) {
                        if (result.type == 'video') {
                            $('#queue_videos').html('上传成功');
                        } else if (result.type == 'cover') {
                            $('#queue_video_covers').html('上传成功');
                        }
                    },
                    error: function (result) {
                        try {
                            bootbox.alert({
                                title: "出错了",
                                message: result.msg,
                                className: 'bb-alternate-modal'
                            });
                        } catch (e) {
                            bootbox.alert({
                                title: "出错了",
                                message: result.toString(),
                                className: 'bb-alternate-modal'
                            });
                        }
                    },
                    progress: function (result) {
                        if (result.type == 'video') {
                            var current_progress = Math.floor(result.curr * 100);
                            var progress = $(".progress-bar");
                            progress.css("width", current_progress + "%");
                            progress.find(".sr-only").text(current_progress + "% 完成");
                        } else if (result.type == 'cover') {
                            $('#queue_video_covers').html(Math.floor(result.curr * 100) + '%');
                        }
                    },
                    finish: function (result) {
                        if (result.fileId) {
                            $('#file_id').val(result.fileId);
                        }
                        if (result.coverUrl) {
                            $('#cover_url').val(result.coverUrl);
                        }
                        $('#url').val(result.videoUrl);
                        $.ajax({
                            url: '{{route("my.videos.store")}}',
                            type: 'POST',
                            data: $("#form").serialize(),
                            dataType: 'json',
                            success: function (res) {
                                if (res && res.code == 0) {
                                    bootbox.alert({
                                        message: "成功的保存视频",
                                        className: 'bb-alternate-modal',
                                        callback: function () {
                                            window.location.href = "{{route('my.videos.index')}}";
                                        }
                                    });
                                }
                                else {


                                    if (res.msg) {
                                        bootbox.alert({
                                            title: "保存视频失败",
                                            message: res.msg,
                                            className: 'bb-alternate-modal'
                                        });
                                    }
                                    else {
                                        bootbox.alert({
                                            title: "发布视频失败",
                                            message: "保存视频失败",
                                            className: 'bb-alternate-modal'
                                        });
                                    }
                                }
                            },
                            error: function (res, err) {
                                bootbox.alert({
                                    title: "发布视频失败",
                                    message: err,
                                    className: 'bb-alternate-modal'
                                });
                            }
                        });
                    }
                });
            };

            // 上传按钮点击事件
            $('#uploadFile').on('click', function () {
                if (!videoFileList.length) {
                    bootbox.alert({
                        message: "请添加视频",
                        className: 'bb-alternate-modal'
                    });
                    return;
                }
                if (!$('#title').val()) {
                    bootbox.alert({
                        message: "请输入视频名称",
                        className: 'bb-alternate-modal'
                    });
                    return;
                }
                if (!$("input[name='classification_id']:checked").val()) {
                    bootbox.alert({
                        message: "请选择视频分类",
                        className: 'bb-alternate-modal'
                    });
                    return;
                }
                if (!$("input[name='visibility']:checked").val()) {
                    bootbox.alert({
                        message: "请选择谁可以看",
                        className: 'bb-alternate-modal'
                    });
                    return;
                }
                if (!coverFileList.length) {
                    bootbox.confirm({
                        message: "您没有上传视频封面，确定要继续吗？",
                        buttons: {
                            confirm: {
                                label: '继续',
                                className: 'btn-success'
                            },
                            cancel: {
                                label: '取消',
                                className: 'btn-danger'
                            }
                        },
                        callback: function (result) {
                            if (!result) {
                                return;
                            }
                            startUploader();
                        }
                    });
                }
                else {
                    startUploader();
                }

            });
        });
    </script>
@endsection