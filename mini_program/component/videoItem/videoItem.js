// component/videoItem/videoItem.js
import * as API from '../../utils/API';
import * as util from '../../utils/util';

Component({
    /**
     * 组件的属性列表
     */
    properties: {
        video: {
            type: Object,
            value: {}
        },

        index: {
            type: Number,
            value: 0,
        },

        currentId: {
            type: Number,
            value: 0
        }
    },

    /**
     * 组件的初始数据
     */
    data: {
        loaded: false,
    },

    attached() {
        const {cover_url} = this.data.video;

        if (cover_url) {
            wx.downloadFile({
                url: cover_url,
                success: (res) => {
                    if (res.statusCode === 200) {
                        this.setData({
                            loaded: true,
                            [`video.cover_url`]: res.tempFilePath
                        })
                    }
                }
            });
        }
    },

    /**
     * 组件的方法列表
     */
    methods: {
        videoPlay(event) {
            const {id} = event.currentTarget.dataset;
            util.ajaxCommon(`${API.URL_PLAY_VIDEO}/${id}/play`, {}, {
                method: 'POST',
                needToken: false,
                success: (res) => {
                    console.log(res);
                }
            });
            this.triggerEvent('play-video', {
                id,
            });
        },
        changeCollection(event) {
            const {id, index, status} = event.currentTarget.dataset;
            if (status) {
                util.ajaxCommon(`${API.URL_LIKE_VIDEO}/${id}`, {}, {
                    method: 'DELETE',
                    needToken: true,
                    loading: false,
                    success: (res) => {
                        if (res.code == API.SUCCESS_CODE) {
                          console.log(res);
                            wx.showToast({
                                title: res.msg,
                                mask: true,
                                icon: "success",
                                duration: 1500,
                                image: "/images/smiling.png"
                            });
                            this.triggerEvent('collection-changed', {
                                index: index,
                                liked: false,
                            });
                        }
                        else {
                            wx.showToast({
                                title: res.msg,
                                mask: true,
                                icon: "success",
                                duration: 2500,
                                image: "/images/sad.png"
                            });
                        }
                    }
                });
            } else {
                util.ajaxCommon(API.URL_LIKE_VIDEO, {
                    "video_id": id,
                }, {
                    method: 'POST',
                    loading: false,
                    needToken: true,
                    success: (res) => {
                      console.log(res);
                        if (res.code == API.SUCCESS_CODE) {
                            wx.showToast({
                                title: res.msg,
                                mask: true,
                                icon: "success",
                              duration: 1500,
                                image: "/images/smiling.png"
                            });
                            this.triggerEvent('collection-changed', {
                                index: index,
                                liked: true,
                            });
                        }
                        else {
                            wx.showToast({
                                title: res.msg,
                                mask: true,
                                icon: "success",
                              duration: 1500,
                                image: "/images/sad.png"
                            });
                        }
                    }
                });
            }
        },
        followVideo(event) {
            const {id} = event.currentTarget.dataset;
            util.ajaxCommon(API.URL_FOLLOWED, {
                'wechat_id': id,
            }, {
                method: "POST",
                needToken: true,
                loading: false,
                success: (res) => {
                    if (res.code == API.SUCCESS_CODE) {
                        wx.showToast({
                            title: res.msg,
                            mask: true,
                            icon: "success",
                          duration: 1500,
                            image: "/images/smiling.png"
                        });
                        this.triggerEvent('follow-changed', {
                            id,
                        }, {});
                    }
                    else {
                        wx.showToast({
                            title: res.msg,
                            mask: true,
                            icon: "success",
                          duration: 1500,
                            image: "/images/sad.png"
                        });
                    }
                }
            });
        },

        goVideoDetail() {
            const {id} = this.data.video;
            wx.navigateTo({
                url: `/pages/detail/detail?id=${id}`,
            })
        },

        saveVideoToAlbum(event) {
            let id = event.currentTarget.dataset.id;
            wx.showToast({
                title: '正在制作二维码',
                icon:"loading"
            });
            wx.downloadFile({
                url: `${API.QR_CODE_VIDEO}?page=pages/detail/detail&scene=${id}`,
                success(res) {
                    wx.saveImageToPhotosAlbum({
                        filePath: res.tempFilePath,
                        success(res) {
                            wx.hideLoading()
                            wx.showModal({
                                title: '分享二维码已保存到系统相册',
                                content: '快去分享给朋友，让更多的朋友发现这里的美好',
                                success: function (res) {
                                    if (res.confirm) {
                                        console.log('用户点击确定')
                                    } else if (res.cancel) {
                                        console.log('用户点击取消')
                                    }
                                }
                            })
                        },
                        fail(res) {
                          console.log(res);
                            wx.hideLoading();
                            wx.showToast({
                                title: res.errMsg || '分享失败',
                                icon: 'success',
                                image: "/images/sad.png",
                                duration: 1500
                            });
                        }
                    })
                },
                fail: function (res) {
                    wx.hideLoading()
                    console.log('下载失败')
                },
                complete: function(){
                    console.log('下载完成')
                    //wx.hideToast();
                }
            })
        },
    }
})
