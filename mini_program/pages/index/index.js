//index.js
//获取应用实例
import * as util from '../../utils/util';
import * as API from '../../utils/API';


const app = getApp()

Page({
  data: {
    navList: [],
    videoList: [],
    activeId: 0,
    currentId: 0,
    currentPage: 0,
    lastPage: 0,
  },

  onLoad(options) {
    this.getNavList();
  },

  onPullDownRefresh(){
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
    const { currentPage,lastPage } = this.data;

    if(currentPage >= lastPage){
      /*到底了*/
    } else {
      this.getVideoList();
    }

  },

  getNavList(){
     util.ajaxCommon(API.URL_GET_HEADER_NAV, {}, {
       success: (res) => {
         if(res.code == API.SUCCESS_CODE){

           if(res.data.length){
             this.setData({
               navList: res.data,
               activeId: res.data[0].id,
             }, () => {
               this.getVideoList();
             });
           }
         }
       }
     });
  },

  getVideoList(){
    let { activeId, currentPage, videoList } = this.data;

    currentPage += 1;

    util.ajaxCommon(API.URL_GET_VIDEOS, {
      classification: activeId,
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

  changeNav(event){
    const { id } = event.currentTarget.dataset;

    this.setData({
      activeId: id,
      videoList: [],
      currentId: 0,
      currentPage: 0,
      lastPage: 0,
    }, () => {
      this.getVideoList();
    });
  },

  playVideo(event){
    if(this.videoContext){
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

  collentionChanged(event){
    const { index, liked } = event.detail;

    let liked_number = this.data.videoList[index].liked_number;
    const likeCountStr = `videoList[${index}].liked`;
    const likeNumberStr = `videoList[${index}].liked_number`;



    this.setData({
      [likeCountStr]: liked,
      [likeNumberStr]: liked ? liked_number+1 : liked_number-1,
    })
  },

  followChanged(event){
    let { id } = event.detail;
    let { videoList } = this.data;

    for(let item of videoList){
      if(item.wechat.id == id){
        item.wechat.followed = true;
      }
    }

    this.setData({
      videoList,
    })
  },
})
