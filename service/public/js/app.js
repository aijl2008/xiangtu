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
                        __alert("已喜欢");
                        _this.html('<i class="fa fa-heart"></i>' + res.data.liked_number);
                    }
                    else {
                        __alert(res.msg);
                    }
                },
                error: function (res, err, msg) {
                    if (res.status == 401) {
                        __alert("请登录");
                    }
                    else {
                        __alert(msg);
                    }
                }
            }
        );
    });
});