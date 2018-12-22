const VodUploader = require('../../lib/vod-web-sdk-v5.1');
import * as util from '../../utils/util';
import * as API from '../../utils/API';

const app = getApp()

Page(
  {
  data: {
    fileName: '',
    visibility:1,
    visibilities: [
      { name: '公开，所有的人可以观看', value: '1', checked: 'true' },
      { name: '保护，仅我自已和我的粉丝可以观看', value: '2' },
      { name: '私密，仅我自己可以观看', value: '3' },
    ],
    classification:0,
    classifications: [],

  },


  onLoad(options) {
    this.get_classifications();
  },

  get_classifications() {
    util.ajaxCommon(API.URL_GET_HEADER_NAV, {}, {
      success: (res) => {
        if (res.code == API.SUCCESS_CODE) {

          if (res.data.length) {
            this.setData({
              classifications: res.data,
              //activeId: res.data[0].id,
            }, () => {
              //this.getVideoList();
            });
          }
        }
      }
    });
  },

  visibilityChange: function (e) {
    this.data.visibility = e.detail.value;
  },

  classificationChange: function (e) {
    this.data.classification = e.detail.value;
  },

  /**
 * 生命周期函数--监听页面显示
 */
  onShow: function () {

  },
  getSignature: function (callback) {

    util.ajaxCommon(API.URL_VOD_SIGNATURE, {
    }, {
        needToken: true,
        success: (res) => {
          console.log(res);

          if (res.code == API.SUCCESS_CODE) {


            
            if (res.data && res.data.signature) {
              callback(res.data.signature);
            } else {
              return '获取签名失败';
            }
          }
        }
      });

  },
  inputChange: function (evt) {
    this.fileName = evt.detail.value;
  },
  chooseFile: function () {
    var This = this;
    wx.chooseVideo({
      sourceType: ['album', 'camera'],
      compressed: true,
      maxDuration: 60,
      success: function (file) {
        VodUploader.start({
          videoFile: file, //必填，把chooseVideo回调的参数(file)传进来
          fileName: This.fileName, //选填，视频名称，强烈推荐填写(如果不填，则默认为“来自微信小程序”)
          getSignature: This.getSignature, //必填，获取签名的函数
          success: function (result) {
            console.log('success');
            console.log(result);
          },
          error: function (result) {
            console.log('error');
            console.log(result);
            wx.showModal({
              title: '上传失败',
              content: JSON.stringify(result),
              showCancel: false
            });
          },
          progress: function (result) {
            console.log('progress');
            console.log(result);
            wx.showModal({
              title: '上传中',
              content: result.percent * 100 + '%',
              showCancel: false
            });
          },
          finish: function (result) {
            console.log('finish');
            console.log(result);


            /**
             * 通知服务器上传成功
             */
            var formData = {
              title: result.videoName,
              url: result.videoUrl,
              cover_url: "",
              file_id: result.fileId,
              visibility: 1,
              classification_id: 1
            };

            console.log(API.URL_VIDEO_UPLOAD_SUCCESS,formData);
            util.ajaxCommon(API.URL_VIDEO_UPLOAD_SUCCESS, formData, {
                method: "POST",
                needToken: true,
                success: (res) => {
                  console.log(res);

                  if (res.code == API.SUCCESS_CODE) {



                    wx.showModal({
                      title: '上传成功',
                      content: 'fileId:' + result.fileId + '\nvideoName:' + result.videoName,
                      showCancel: false
                    });

                    wx.navigateTo({
                      url: '/pages/uploadList/uploadList'
                    });
                  }
                }
              });



            
          }
        });
      }
    })
  }
})