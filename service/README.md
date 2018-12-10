# 接口

## 视频列表

### 接口地址 
`GET /api/videos`
### 响应内容 

```
{
    "code":0,
    "data":[
        {
            "id":1,
            "url":"http://video.url",
            "title":"北大某医院，挂号费300",
            "played_number":123,
            "liked_number":193,
            "shared_to_wechat_number":90,
            "shared_to_moment_number":910,
            "user_id":"使用微信的open_id",
            "uploaded_at":"刚刚",
            "user":{
                "nick_name":"",
                "avatar":"http://avatar.url"
            }
        },
        {
            "id":1,
            "url":"http://video.url",
            "title":"北大某医院，挂号费300",
            "played_number":123,
            "liked_number":193,
            "shared_to_wechat_number":90,
            "shared_to_moment_number":910,
            "user_id":"使用微信的open_id",
            "uploaded_at":"刚刚",
            "user":{
                "nick_name":"",
                "avatar":"http://avatar.url"
            }
        }
    ],
    ,
    "current_page":1,
    "first_page_url":"first_page_url",
    "from":null,
    "last_page":1,
    "last_page_url":"last_page_url",
    "next_page_url":null,
    "path":"path",
    "per_page":15,
    "prev_page_url":null,
    "to":null,
    "total":0
}
```

## 视频详情

### 接口地址 
`GET /api/videos/{video_id}`
### 响应内容 

```
{
    "code":0,
    "data":{
        "id":1,
        "url":"http://video.url",
        "title":"北大某医院，挂号费300",
        "played_number":123,
        "liked_number":193,
        "shared_to_wechat_number":90,
        "shared_to_moment_number":910,
        "user_id":"使用微信的open_id",
        "uploaded_at":"刚刚",
        "user":{
            "nick_name":"",
            "avatar":"http://avatar.url"
        },
        "related_videos":[

        ]
    }
}
```

## 添加视频
### 接口地址 
`POST /api/videos/`
### 参数
参数名称|类型|说明
---|---|---
url|string|视频播放地址,由点播服务器返回
title|string|视频标题
visibility|string|谁可以看,public：任何人,protected:关注着,private:仅自己
### 响应内容
```
{
    "coode":0,
    "msg":"success",
    "data":{
        "id":1
    }
}
```

## 收藏视频
### 接口地址 
收藏 `GET /api/videos/{video_id}/like`

取消 `DELETE /api/videos/{video_id}/like`
### 请求参数
`不需要`
### 响应内容
```
{
    "coode":0,
    "msg":"success"
}
```


## 关注
### 接口地址 
关注 `POST /api/users/{user_id}/follow`

取消 `DELETE /api/users/{user_id}/follow`
### 请求参数
`不需要`
### 响应内容
```$xslt
{
    "coode":0,
    "msg":"success"
}
```

## 获取视频上传签名
### 接口地址 
`GET /api/qcloud/vod/signature`

## 获取分享签名
### 接口地址 
`GET /api/share/wechat/signature`

## 关注页
### 接口地址 
`GET /api/followed`
### 响应内容
`参考视频列表`

## 收藏页
### 接口地址 
`GET /api/user/liked`
### 响应内容
`参考视频列表`

## 浏览历史页
### 接口地址 
`GET /api/user/history`
### 响应内容
`参考视频列表`

## 个人主页
### 接口地址 
`GET /api/user/profile`
### 响应内容
```
{
    "nick_name":"",
    "avatar":"http://avatar.url",
    "followed_number":0,
    "been_followed_number":0,
    "uploaded_number":0
}
```

## 分享页
### 接口地址 
`GET /api/user/{user_id}/profile`
### 响应内容
`参考个人主页`

## 统计页
### 接口地址 
`GET /api/user/statistics`
### 响应内容
```
{
}
```