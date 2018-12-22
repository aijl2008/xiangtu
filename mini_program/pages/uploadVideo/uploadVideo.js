// pages/uploadVideo/uploadVideo.js
const VodUploader = require('../../lib/vod-web-sdk-v5.1');

Page({

  /**
   * 页面的初始数据
   */
  data: {
    videoTem: null,
    videoName: '',
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    wx.chooseVideo({
      success: (res) => {
        this.setData({
          videoTem: res.tempFilePath
        });
      },
      fail: () => {

      }
    })
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

  editVideoName(event){
    const { vaule } = event.detail;

    this.setData({
      videoName: value,
    })
  },

  getSignature: function(callback) {
    wx.request({
      url: 'https://www.xiangtu.net.cn/api/qcloud/signature/vod',
      method: 'GET',
      data: {
        Action: 'GetVodSignatureV2'
      },
      dataType: 'json',
      success: function(res) {
        if (res.data && res.data.data.signature) {
          callback(res.data.data.signature);
        } else {
          return '获取签名失败';
        }
      }
    });
  },

  submit(){
    const { videoTem, videoName } = this.data;

    if(!videoTem){
      /*未上传视频*/
    } else {
      VodUploader.start({
        videoFile: videoTem, //必填，把chooseVideo回调的参数(file)传进来
        fileName: videoName, //选填，视频名称，强烈推荐填写(如果不填，则默认为“来自微信小程序”)
        getSignature: this.getSignature, //必填，获取签名的函数
        success: function(result) {
          console.log('success');
          console.log(result);
        },
        error: function(result) {
          console.log('error');
          console.log(result);
          wx.showModal({
            title: '上传失败',
            content: JSON.stringify(result),
            showCancel: false
          });
        },
        progress: function(result) {
          console.log('progress');
          console.log(result);
        },
        finish: function(result) {
          console.log('finish');
          console.log(result);
          wx.showModal({
            title: '上传成功',
            content: 'fileId:' + result.fileId + '\nvideoName:' + result.videoName,
            showCancel: false
          });
        }
      });
    }
  }
})