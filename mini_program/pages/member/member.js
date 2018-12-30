// pages/member/member.js
import * as util from "../../utils/util";
import * as API from "../../utils/API";

Page({

  /**
   * 页面的初始数据
   */
  data: {
    id: 0,
    user: {}
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let id = options.scene || options.id;
    this.setData(
      {
        id: id
      }
    );
    this.getMemberDetail();
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
    this.getMemberDetail();
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

  getMemberDetail(id) {
    let _this = this;
    util.ajaxCommon(`${API.URL_MEMBER_DETAIL}` + this.data.id, {}, {
      success: (res) => {
        console.log(res);
        if (res.code == API.SUCCESS_CODE) {
          console.log(res.data);
          _this.setData({
            user: res.data
          });
        }
        else{
          console.log(res.code);
        }
      }
    })
  },

  
  followUser(event) {
    console.log(event.currentTarget.dataset);
    const { id } = event.currentTarget.dataset;

    util.ajaxCommon(API.URL_FOLLOWED, {
      'wechat_id': id,
    }, {
        method: "POST",
        needToken: true,
        success: (res) => {
          if (res.code == API.SUCCESS_CODE) {
            this.setData({
              ['user.followed']: true,
            })
          }
        }
      });
  },

  cancelFollowUser(event) {
    console.log(event.currentTarget.dataset);
    const { id } = event.currentTarget.dataset;

    util.ajaxCommon(API.URL_FOLLOWED, {
      'wechat_id': id,
    }, {
        method: "POST",
        needToken: true,
        success: (res) => {
          if (res.code == API.SUCCESS_CODE) {
            this.setData({
              ['user.followed']: false,
            })
          }
        }
      });
  },

  jumpVideoDetail(event) {
    const { id } = event.currentTarget.dataset;

    wx.navigateTo({
      url: `/pages/detail/detail?id=${id}`,
    })
  }
})