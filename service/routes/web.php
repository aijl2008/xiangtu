<?php
/**
 * 首页
 */
Route::get("/", "IndexController@index")->name('home');
Route::get("/vue", "VueController@index");
Route::get("/videos/{video}", "VideoController@show")->name('video.show');


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

        Route::post('profile/upload', 'ProfileController@upload');
        Route::resource('profile', 'ProfileController');


        Route::Get('statistics', 'StatisticsController')->name('statistics.show');
    }
);

/**
 * 公众号消息接口
 */
Route::any('/wechat', 'WechatServerController@serve')->name('wechat.serve');
Route::any('/qr_code/mini_program', 'QRCodeController@miniProgram');