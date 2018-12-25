// pages/uploadList/uploadList.js
import * as util from '../../utils/util';
import * as API from '../../utils/API';

Page({

  /**
   * 页面的初始数据
   */
  data: {
    videoList: [],
    activeId: 0,
    currentId: 0,
    currentPage: 0,
    lastPage: 0,
  },

  onPullDownRefresh() {
    this.setData({
      videoList: [],
      activeId: 0,
      currentId: 0,
      currentPage: 0,
      lastPage: 0,
    }, () => {
      this.getVideoList();
    })
  },

  onReachBottom() {
    const { currentPage, lastPage } = this.data;

    if (currentPage >= lastPage) {
      /*到底了*/
    } else {
      this.getVideoList();
    }

  },

  getVideoList() {
    let { activeId, currentPage, videoList } = this.data;

    currentPage += 1;
    console.log(API.URL_GET_MY_VIDEOS);
    util.ajaxCommon(API.URL_GET_MY_VIDEOS, {
      classification: activeId,
      page: currentPage,
    }, {
        success: (res) => {
          console.log(res);
          if (res.code == API.SUCCESS_CODE) {
            console.log(res.data.data.length);
            if (res.data.data.length) {
              this.setData({
                videoList: videoList.concat(res.data.data),
                lastPage: res.data.last_page,
                currentPage,
              })
            }
            console.log(this.data);
          }
        },
        error:(res)=>{
          console.log(res);
        }
      })
  },

  playVideo(event) {
    if (this.videoContext) {
      this.videoContext.stop();
    }

    const { id } = event.detail;

    this.setData({
      currentId: id,
    }, () => {
      this.videoContext = wx.createVideoContext(`video_${id}`);

      console.log(this.videoContext);

      this.videoContext.play();
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
    this.getVideoList();
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

  jumpToUpload(){
    wx.navigateTo({
      url: '/pages/uploadVideo/uploadVideo'
    });
  }
})
