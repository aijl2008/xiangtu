@extends('layouts.app')
@section('title', '视频分类管理')
@section('content')
    <h3>视频分类管理</h3>
    <hr>
    @include('layouts/message')
    <table class="table table-borderless">
        <thead>
        <tr>
            <th>操作</th>
            <th class="text-nowrap">编号</th>
            <th class="text-nowrap">收信人</th>
            <th class="text-nowrap">发信人</th>
            <th class="text-nowrap">时间</th>
            <th class="text-nowrap">类型</th>

            <th class="text-nowrap">content</th>
            <th class="text-nowrap">pic_url</th>
            <th class="text-nowrap">media_id</th>
            <th class="text-nowrap">title</th>
            <th class="text-nowrap">app_id</th>
            <th class="text-nowrap">page_path</th>
            <th class="text-nowrap">thumb_url</th>
            <th class="text-nowrap">thumb_media_id</th>
            <th class="text-nowrap">session_from</th>
            <th class="text-nowrap">记录时间</th>
            <th class="text-nowrap">更新时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                <td class="text-nowrap">{{ $row->id }}</td>
                <td class="text-nowrap">{{ $row->to_user_name }}</td>
                <td class="text-nowrap">{{ $row->fromWechat->nickname??$row->from_user_name }}</td>
                <td class="text-nowrap">{{ $row->create_time }}</td>
                <td class="text-nowrap">{{ $row->msg_type }}</td>
                <td class="text-nowrap">
                    @if ($row->msg_type =="text")
                        <a data-url="{!! route('admin.messages.update', $row->id) !!}"
                           class="reply">{{ $row->content }}</a>
                    @endif

                </td>
                <td class="text-nowrap">{{ $row->pic_url }}</td>
                <td class="text-nowrap">{{ $row->media_id }}</td>
                <td class="text-nowrap">{{ $row->title }}</td>
                <td class="text-nowrap">{{ $row->app_id }}</td>
                <td class="text-nowrap">{{ $row->page_path }}</td>
                <td class="text-nowrap">{{ $row->thumb_url }}</td>
                <td class="text-nowrap">{{ $row->thumb_media_id }}</td>
                <td class="text-nowrap">{{ $row->session_from }}</td>
                <td class="text-nowrap">{{ $row->created_at }}</td>
                <td class="text-nowrap">{{ $row->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div id="message-box" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div style="margin: 15px">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="message" id="message" class="form-control"></textarea>
                        </div>
                        <button type="button" id="reply" class="btn btn-default">回复</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#admin_classifications_index').addClass("active");
            var targetUrl;
            $('.reply').click(function () {
                targetUrl = $(this).data("url");
                console.log(targetUrl);
                $('#message-box').modal('show');
                return;
            });
            $('#reply').click(function () {
                if (!targetUrl) {
                    bootbox.alert({
                        title: "乡土味",
                        message: "浏览器端错误",
                        className: 'bb-alternate-modal'
                    });
                }
                var _this = $(this);
                console.log(targetUrl);
                $.ajax(
                    {
                        url: targetUrl,
                        type: "PUT",
                        data: {
                            message: $('#message').val()
                        },
                        dataType: "json",
                        success: function (res) {
                            console.log(res);
                            if (res.code == 0) {
                                bootbox.alert({
                                    title: "乡土味",
                                    message: res.msg,
                                    className: 'bb-alternate-modal',
                                    callback: function () {
                                        $('.modal').modal('hide');
                                    }
                                });
                            }
                            else {
                                bootbox.alert({
                                    title: "乡土味",
                                    message: res.msg,
                                    className: 'bb-alternate-modal'
                                });
                            }
                        },
                        error: function (res, err, msg) {
                            bootbox.alert({
                                title: "乡土味",
                                message: msg,
                                className: 'bb-alternate-modal'
                            });
                        }
                    }
                );
            });
        });
    </script>
@endsection