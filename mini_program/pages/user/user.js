// pages/user/user.js
import * as util from "../../utils/util";
import * as API from "../../utils/API";

Page({

  /**
   * 页面的初始数据
   */
  data: {
    userInfo: {
      "avatar": "/images/user-64.png",
      "nickname": "",
      "followed_number": 0,
      "be_followed_number": 0,
      "uploaded_number": 0
    },
  },

  save_to_album() {
    wx.downloadFile({ // 调用wx.downloadFile接口将图片下载到小程序本地
      url: API.QR_CODE + "?scene=pages/user/user",
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
            wx.hideLoading()
            console.log('分享失败')
          }
        })
      },
      fail: function (res) {
        wx.hideLoading()
        console.log('分享失败')
      }
    })
  },


  errImg: function (e) {
    this.setData({
      ["userInfo.avatar"]: "/images/user-64.png"
    });
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    if(util.checkToken()){
      this.getUserMes();
    }
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },


  getUserMes(){
    util.ajaxCommon(API.URL_USER_DETAIL, {}, {
      method: "GET",
      needToken: true,
      success: (res) => {
        if(res.code == 0){
          this.setData({
            userInfo: res.data.user
          })
        }
      }
    })
  }
})
