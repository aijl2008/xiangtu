import * as API from "./API";

const formatTime = date => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()
  const hour = date.getHours()
  const minute = date.getMinutes()
  const second = date.getSeconds()

  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

const formatNumber = n => {
  n = n.toString()
  return n[1] ? n : '0' + n
}

const checkToken = function () {
  const token = wx.getStorageSync('token');

  if(token){
    return true;
  } else {
    // 查看是否授权
    wx.navigateTo({
      url: "/pages/login/login"
    });

    return false;
  }
}

/**
 * 全局通用网络请求方法
 */
const ajaxCommon = function(url, data, {method = "GET", needToken, success, fail, complete, needHideLoadingIndicator = false}) {
  if (needToken) {
    if(!checkToken()){
      return false;
    }
  }

  wx.showLoading({
    mask: true,
  });
  let finalData = {};
  let token = wx.getStorageSync('token');
  Object.assign(finalData, data);

  wx.request({
    url,
    header: {
      Accept: '',
      Authorization: token ? `Bearer ${token}` : '',
    },
    data: finalData,
    method: method,
    success: function (response) {
      if(response.data.code == 401){
        wx.showToast({
          title: 'token异常，请重新登录',
          icon: 'none',
          mask: true,
          complete: (res) => {
            wx.removeStorage({
              key: 'token',
              success(){
                wx.navigateTo({
                  url: '/pages/login/login',
                })
              }
            });
          }
        })
      } else  if (typeof success === 'function') {
        success(response.data);
      }

    },
    fail: function (res) {
      console.log('fail', res);
      if (typeof fail === 'function') {
        fail(res);
      } else {
        wx.showToast({
          title: '您的网络不太给力'
        })
      }
    },
    complete: function (res) {
      console.log(res);
      wx.hideLoading();
      if (typeof complete === 'function') {
        complete(res);
      }
      !needHideLoadingIndicator && wx.hideNavigationBarLoading();
    }
  })
}

module.exports = {
  formatTime,
  formatNumber,
  ajaxCommon,
  checkToken,
}
