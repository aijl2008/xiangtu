<?php

/**
 * 小程序快捷登录
 */
Route::any('mini_program/token', 'Api\MiniProgramController@token')->name('api.mini_program.token');

/**
 * 全部视频
 */
Route::resource('videos', 'Api\VideoController', [
    'only' => [
        'index', 'show'
    ]
]);
/**
 * Vod 事件服务
 */
Route::any('vod/service/event', 'Api\Vod\ServiceController@event');
Route::any('vod/service', 'Api\Vod\ServiceController@event');
/**
 * 视频分类
 */
Route::resource('classifications', 'Api\ClassificationController', [
    'only' => ['index']
]);

Route::group(
    [
        'middleware' => 'auth:api',
        'prefix' => '',
        'namespace' => 'Api',
        'as' => 'api.'
    ],
    function () {
        /**
         * 显示小程序当前用户，方便token测试
         */
        Route::any('mini_program/user', 'MiniProgramController@user')->name('mini_program.user');
        /**
         * VOD上传签名
         */
        Route::get("qcloud/signature/vod", "QCloud\SignatureController@Vod")->name('qcloud.signature.vod');

        /**
         * 分享签名
         */
        Route::get("wechat/signature/share", "Wechat\SignatureController@share")->name('wechat.signature.share');


        /**
         * 全部用户
         */
        Route::resource('users', 'WechatController');

        Route::group(
            [
                'prefix' => 'my',
                'namespace' => 'My',
                'as' => 'my.'
            ],
            function () {
                /**
                 * 我的视频
                 */
                Route::resource("videos", "VideoController");
                /**
                 *  我关注的
                 */
                Route::resource('followed', 'FollowController');
                /**
                 * 我喜欢的
                 */
                Route::resource('liked', 'LikeController');

                /**
                 * 个人资料显示与修改
                 */
                Route::get('profile', 'ProfileController@index')->name('profile.show');
                Route::patch('profile', 'ProfileController@update')->name('profile.update');
            }
        );

        /**
         * 统计
         */
        Route::Get('statistics', 'My\StatisticsController')->name('users.statistics.show');

    }
);
