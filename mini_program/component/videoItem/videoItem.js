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
    const { cover_url } = this.data.video;

    if(cover_url){
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
    videoPlay(event){
      const { id } = event.currentTarget.dataset;

      this.triggerEvent('play-video', {
        id,
      });
    },

    changeCollection(event){
      const {id, index, status} = event.currentTarget.dataset;

      if(status){
        util.ajaxCommon(`${API.URL_LIKE_VIDEO}/${id}`, {}, {
          method: 'DELETE',
          needToken: true,
          success: (res) => {
            if(res.code == API.SUCCESS_CODE){
              this.triggerEvent('collection-changed', {
                index: index,
                liked: false,
              });
            }
          }
        });
      } else {
        util.ajaxCommon(API.URL_LIKE_VIDEO, {
          "video_id": id,
        }, {
          method: 'POST',
          needToken: true,
          success: (res) => {
            if(res.code == API.SUCCESS_CODE){
              this.triggerEvent('collection-changed', {
                index: index,
                liked: true,
              });
            }
          }
        });
      }
    },
    followVideo(event) {
      const { id } = event.currentTarget.dataset;

      util.ajaxCommon(API.URL_FOLLOWED, {
        'wechat_id': id,
      }, {
        method: "POST",
        needToken: true,
        success: (res) => {
          if(res.code == API.SUCCESS_CODE){
            this.triggerEvent('follow-changed', {
              id,
            }, {});
          }
        }
      });
    },

    goVideoDetail(){
      const { id } = this.data.video;

      wx.navigateTo({
        url: `/pages/detail/detail?id=${id}`,
      })
    }
  }
})
