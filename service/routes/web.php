<?php
/**
 * 首页
 */

Route::get("/vue", "VueController@index");

/**
 * 公开页面，视频播放
 */
Route::get("/videos/{video}", "VideoController@show")->name('videos.show');
Route::get("/", "VideoController@index")->name('home');
Route::post("/videos/{video}/play", "VideoController@play")->name('videos.play');
/**
 * 管理员登录
 */
Route::group(
    [
        'prefix' => 'admin',
        "namespace" => "Admin",
        'as' => 'admin.'
    ],
    function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login.show');
        Route::post('login', 'LoginController@login')->name('login.do');
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::get('register', 'RegisterController@showRegistrationForm')->name('register.show');
        Route::post('register', 'RegisterController@register')->name('register.do');


    }
);


/**
 * 管理页面组
 */
Route::group(
    [
        'middleware' => 'auth:admin',
        'prefix' => 'admin',
        "namespace" => "Admin",
        'as' => 'admin.'
    ],
    function () {
        /**
         * 首页
         */
        Route::get("/", "HomeController@index")->name('home');


        Route::resource("/classifications", "ClassificationController", [
            'except' => [
                'show'
            ]
        ]);

        Route::resource("/messages", "MessageController", [
            'except' => [
                'show'
            ]
        ]);

        Route::resource("/logs", "LogController", [
            'only' => [
                'index'
            ]
        ]);


        /**
         * 用户页
         */
        Route::resource("/users", "UserController", [
            'only' => [
                'index', 'show'
            ]
        ]);
        /**
         * 视频列表
         */
        Route::resource("videos", "VideoController", [
            'only' => [
                'index', 'show'
            ]
        ]);
        Route::any("videos/{video}/snapshot", "VideoController@snapshot");
    }
);


/**
 * 用户登录（微信登录）
 */
Route::group(
    [
        'prefix' => 'wechat',
        'as' => 'wechat.'
    ],
    function () {
        Route::get('login', 'WechatAuthController@showLoginForm')->name('login.show');
        Route::get('login/mock/{user}', 'WechatAuthController@mock')->name('login.mock');
        Route::get('login/redirect', 'WechatAuthController@redirect')->name('login.redirect');
        Route::get('login/do', 'WechatAuthController@callback')->name('login.do');
        Route::get('logout', 'WechatAuthController@logout')->name('logout');
    }
);

/**
 * "我的"页面组
 */
Route::group(
    [
        'middleware' => 'auth:wechat',
        'prefix' => 'my',
        "namespace" => "My",
        'as' => 'my.'
    ],
    function () {
        /**
         * 首页
         */
        Route::get("/", "HomeController@index")->name('home');
        /**
         * 视频列表
         */
        Route::resource("videos", "VideoController");
        Route::resource('followed', 'FollowController');
        Route::resource('liked', 'LikeController');

        Route::post('profile/upload', 'ProfileController@upload')->name('profile.upload');
        Route::post('profile', 'ProfileController@update')->name('profile.update');
        Route::get('profile', 'ProfileController@index')->name('profile');
        /**
         * signature
         */
        Route::get("qcloud/signature/vod", "QCloud\SignatureController@Vod")->name('qcloud.signature.vod');


        Route::Get('statistics', 'StatisticsController@index')->name('statistics.index');
        Route::Get('statistics/video', 'StatisticsController@video')->name('statistics.video');
        Route::Get('statistics/follower', 'StatisticsController@follower')->name('statistics.follower');
    }
);

/**
 * 公众号消息接口
 */
Route::any('/wechat', 'WechatServerController@serve')->name('wechat.serve');
Route::any('/qr_code/mini_program', 'QRCodeController@miniProgram');