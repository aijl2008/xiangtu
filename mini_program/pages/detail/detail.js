// pages/detail/detail.js
import * as util from '../../utils/util';
import * as API from '../../utils/API';

Page({

  /**
   * 页面的初始数据
   */
  data: {
    id: 0,
    videoDetail: {},
    currentPage: 0,
    videoList: [],
    lastPage: 0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    const { id } = options;
    this.setData({
      id,
    }, () => {
      this.getVideoDetail();
    });
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
  onPullDownRefresh(){
    this.setData({
      videoList: [],
      currentPage: 0,
      lastPage: 0,
    }, () => {
      this.getVideoList();
    })
  },

  onReachBottom() {
    const { currentPage,lastPage } = this.data;

    if(currentPage >= lastPage){
      /*到底了*/
    } else {
      this.getVideoList();
    }

  },
  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },

  getVideoDetail(){
    util.ajaxCommon(`${API.URL_VIDEO_DETAIL}${this.data.id}}`, {}, {
      success: (res) => {
        if(res.code == API.SUCCESS_CODE){
          this.setData({
            videoDetail: res.data,
          }, () => {
            this.getVideoList();
          })
        }
      }
    })
  },

  changeCollection(){
    const { id, videoDetail } = this.data;

    if(videoDetail.liked){
      util.ajaxCommon(`${API.URL_LIKE_VIDEO}/${id}`, {}, {
        method: 'DELETE',
        needToken: true,
        success: (res) => {
          if(res.code == API.SUCCESS_CODE){
            Object.assign(videoDetail, {
              liked: false,
              liked_number: videoDetail.liked_number - 1
            });

            this.setData({
              videoDetail
            });
          }
        }
      });
    } else {
      util.ajaxCommon(`${API.URL_LIKE_VIDEO}`, {
        "video_id": id,
      }, {
        method: 'POST',
        success: (res) => {
          if(res.code == API.SUCCESS_CODE){
            Object.assign(videoDetail, {
              liked: true,
              liked_number: videoDetail.liked_number + 1
            });

            this.setData({
              videoDetail
            });
          }
        }
      });
    }
  },

  changeFollow(event) {
    const { id, videoDetail } = this.data;

    if(videoDetail.wechat.followed){
      util.ajaxCommon(`${API.URL_FOLLOWED}/${videoDetail.wechat.id}`, {
        'wechat_id': id,
      }, {
        method: "DELETE",
        needToken: true,
        success: (res) => {
          if(res.code == API.SUCCESS_CODE){
            this.setData({
              ['videoDetail.wechat.followed']: false,
            })
          }
        }
      })
    } else {
      util.ajaxCommon(`${API.URL_FOLLOWED}`, {
        'wechat_id': id,
      }, {
        method: "POST",
        needToken: true,
        success: (res) => {
          if(res.code == API.SUCCESS_CODE){
            this.setData({
              ['videoDetail.wechat.followed']: true,
            })
          }
        }
      })
    }
  },

  getVideoList(){
    let { currentPage, videoList, videoDetail } = this.data;

    currentPage += 1;

    util.ajaxCommon(API.URL_GET_VIDEOS, {
      wechat_id: videoDetail.wechat.id,
      page: currentPage,
    }, {
      success: (res) => {
        if(res.code == API.SUCCESS_CODE){
          if(res.data.data.length){
            this.setData({
              videoList: videoList.concat(res.data.data),
              lastPage: res.data.last_page,
              currentPage,
            })
          }
        }
      }
    })
  },
})
