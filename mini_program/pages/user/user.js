// pages/user/user.js
import * as util from "../../utils/util";
import * as API from "../../utils/API";

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
