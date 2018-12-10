@extends('layouts.app')

@section('content')
    <div id="page-content" class="single-page">
        <div class="container">
            <form id="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label">选择视频</label>
                    <div class="col-sm-10">
                        <input type="text" value="" name="url" id="url" readonly="readonly">
                        <input type="hidden" value="" name="file_id" id="file_id">
                        <p class="form-control-static" id="queue_videos"><a id="addVideo"
                                                                            href="javascript:void(0);"
                                                                            class="btn btn-info">添加视频</a></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">选择视频封面</label>
                    <div class="col-sm-10">
                        <input type="text" value="" name="cover_url" id="cover_url" readonly="readonly">
                        <p class="form-control-static" id="queue_video_covers"><a id="addCover"
                                                                                  href="javascript:void(0);"
                                                                                  class="btn btn-info">添加封面</a>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">请输入视频名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" id="title" required="">
                    </div>
                </div>
                <div class="form-group {{ $errors->has('classification_id') ? 'has-error' : ''}}">
                    {!! Form::label('classification_id', '分类', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        <div class="checkbox">
                            {!! Form::select('classification_id', (new \App\Models\Classification())->toOption()); !!}
                        </div>
                        {!! $errors->first('classification_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">谁可以看</label>
                    <div class="col-sm-10">
                        <div class="radio">
                            <label>
                                <input type="radio" name="visibility" id="optionsRadios1" value="1" checked>
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
                        <div class="col-sm-offset-2 col-sm-10">
                            <a id="uploadFile" href="javascript:void(0);" class="btn btn-primary">上传并保存</a>
                        </div>
                    </div>
                </div>
            </form>
            <input id="addVideo-file" type="file" style="display:none;"/>
            <input id="addCover-file" type="file" style="display:none;"/>
        </div>
    </div>
@endsection
@section('js')
    <script src="//imgcache.qq.com/open/qcloud/js/vod/sdk/ugcUploader.js"></script>
    <script type="text/javascript">

        $(function () {
            var index = 0;
            var cosBox = [];
            /**
             * 计算签名
             **/
            var getSignature = function (callback) {
                $.ajax({
                    url: '{{route("api.qcloud.signature.vod")}}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.data && res.data.signature) {
                            callback(res.data.signature);
                        } else {
                            alert('获取签名失败');
                            return null;
                        }
                    },
                    error: function (res, err) {
                        alert('获取签名失败:' + err);
                    }
                });
            };

            /*
             * 取消上传绑定事件，示例一与示例二通用
             */
            $('#resultBox').on('click', '[act=cancel-upload]', function () {
                var cancelresult = qcVideo.ugcUploader.cancel({
                    cos: cosBox[$(this).attr('cosnum')],
                    taskId: $(this).attr('taskId')
                });
                console.log(cancelresult);
            });


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
                if (videoFileList.length) {
                    //var num = addUploaderMsgBox();

                    var resultMsg = qcVideo.ugcUploader.start({
                        videoFile: videoFileList[0],
                        coverFile: coverFileList[0],
                        getSignature: getSignature,
                        allowAudio: 1,
                        success: function (result) {
                            console.log('success', result);
                            if (result.type == 'video') {
                                $('#queue_videos').html('上传成功');
                            } else if (result.type == 'cover') {
                                $('#queue_video_covers').html('上传成功');
                            }
                        },
                        error: function (result) {
                            console.log('error', result);
                            if (result.type == 'video') {
                                $('#queue_videos').html(result.msg);
                            } else if (result.type == 'cover') {
                                $('#queue_video_covers').html(result.msg);
                            }
                        },
                        progress: function (result) {
                            if (result.type == 'video') {
                                $('#queue_videos').html(Math.floor(result.curr * 100) + '%');
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
                                url: '{{route("api.my.videos.store")}}',
                                type: 'POST',
                                data: $("#form").serialize(),
                                dataType: 'json',
                                success: function (res) {
                                    if (res && res.code == 0) {
                                        alert("上传成功");
                                        window.location.href = "{{route('my.videos.index')}}";
                                    }
                                    else {
                                        if (res.msg) {
                                            alert("保存视频失败," + res.msg);
                                        }
                                        else {
                                            alert("保存视频失败");
                                        }
                                    }
                                },
                                error: function (res, err) {
                                    alert('发布视频失败:' + err);
                                }
                            });
                        }
                    });

                } else {
                    alert('请添加视频！\n');
                }

            };

            // 上传按钮点击事件
            $('#uploadFile').on('click', function () {
                startUploader();
                $('#form').reset();
            });
        });
    </script>
    @endsection
    </body>
    </html>