$(function () {
    $(".liked_number").click(function () {
        var _this = $(this);
        console.log(_this.data('video-id'));
        $.ajax(
            {
                url: _this.data('url'),
                type: "post",
                data: {
                    video_id: _this.data('video-id')
                },
                dataType: "json",
                success: function (res) {
                    if (res.code == 0) {
                        bootbox.alert({
                            title: "乡土味",
                            message: res.msg,
                            className: 'bb-alternate-modal'
                        });
                        _this.html('<i class="fa fa-heart"></i>' + res.data.liked_number);
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
                    if (res.status == 401) {
                        bootbox.alert({
                            title: "乡土味",
                            message: "收藏视频请先登录",
                            className: 'bb-alternate-modal'
                        });
                    }
                    else {
                        bootbox.alert({
                            title: "乡土味",
                            message: msg,
                            className: 'bb-alternate-modal'
                        });
                    }
                }
            }
        );
    });

    $(".followed_number").click(function () {
        var _this = $(this);
        console.log(_this.data('wechat-id'));
        $.ajax(
            {
                url: _this.data('url'),
                type: "post",
                data: {
                    wechat_id: _this.data('wechat-id')
                },
                dataType: "json",
                success: function (res) {
                    if (res.code == 0) {
                        bootbox.alert({
                            title: "乡土味",
                            message: res.msg,
                            className: 'bb-alternate-modal'
                        });
                        _this.html('<i class="fa fa-heart"></i>' + res.data.followed_number);
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
                    if (res.status == 401) {
                        bootbox.alert({
                            title: "乡土味",
                            message: "关注请先登录",
                            className: 'bb-alternate-modal'
                        });
                    }
                    else {
                        bootbox.alert({
                            title: "乡土味",
                            message: msg,
                            className: 'bb-alternate-modal'
                        });
                    }
                }
            }
        );
    });
});