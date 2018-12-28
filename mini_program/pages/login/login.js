// pages/login/login.js
Page({

    /**
     * 页面的初始数据
     */
    data: {},

    getUserInfo(res) {
        console.log(res);
        wx.login({
            success(codeRes) {
                if (codeRes.code) {
                    wx.request({
                        url: 'https://www.xiangtu.net.cn/api/mini_program/token',
                        data: {
                            code: codeRes.code,
                            iv: res.detail.iv,
                            encryptedData: res.detail.encryptedData
                        },
                        method: 'POST',
                        success: (result) => {
                            if (result.data.code == 0) {
                                wx.setStorageSync('token', result.data.data.token.accessToken);
                                wx.navigateBack({
                                    delta: 1
                                });
                            }
                        }
                    });
                }
            }
        });
    }
})
