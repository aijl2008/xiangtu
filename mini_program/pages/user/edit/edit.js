// pages/user/edit/edit.js
import * as util from "../../../utils/util";
import * as API from "../../../utils/API";

Page({

  /**
   * 页面的初始数据
   */
  data: {
    userInfo: {},
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getUserMes();
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
  },

  editHeader() {
    wx.chooseImage({
      count: 1,
      success:(res) => {
        const tempFilePaths = res.tempFilePaths;
        wx.uploadFile({
          url: API.URL_USER_DETAIL, // 仅为示例，非真实的接口地址
          filePath: tempFilePaths[0],
          name: 'avatar',
          header: {
            Accept: 'application/json',
            Authorization: `Bearer ${wx.getStorageSync('token')}`,
          },
          formData: {
            nickname: this.data.userInfo.nickname
          },

          success: (result) => {
            if(result.code === 0){
              this.setData({
                userInfo: result.data
              })
            }
          }
        });
      }
    })
  },

  editName(event){
    const value = event.detail.value;

    util.ajaxCommon(API.URL_USER_DETAIL, {
      avatar: this.data.userInfo.avatar,
      nickname: value,
    }, {
      method: "POST",
      success:(res) => {
        if(res.code === 0){
        }
      }
    })
  }
})
