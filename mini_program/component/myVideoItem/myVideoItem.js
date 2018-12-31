// component/myVideoItem/myVideoItem.js
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
                icon: "loading",
                duration: 50000
            });
            wx.downloadFile({
                url: `${API.QR_CODE_VIDEO}?page=pages/detail/detail&scene=${id}`,
                success(res) {
                    wx.hideToast();
                    wx.saveImageToPhotosAlbum({
                        filePath: res.tempFilePath,
                        success(res) {
                            wx.showModal({
                                title: '分享二维码已保存到系统相册',
                                content: '快去分享给朋友，让更多的朋友发现这里的美好',
                                success: function (res) {
                                    if (res.confirm) {
                                    } else if (res.cancel) {
                                    }
                                }
                            })
                        },
                        fail(res) {
                            wx.hideToast();
                            wx.showToast({
                                title: '分享失败',
                                icon: 'success',
                                image: "/images/sad.png",
                                duration: 1500
                            });
                        }
                    })
                },
                fail: function (res) {
                    console.log('下载失败');
                },
                complete: function () {
                    console.log('下载完成');
                }
            })
        },
    }
})
