<?php
return [
    /*
     * 公众号
     */
    'official_account' => [
        'default' => [
            'app_id' => "",
            'secret' => "",
            'token' => "",
            'aes_key' => "",
        ],
    ],

    /*
     * 开放平台第三方平台
     */
    'open_platform' => [
        'default' => [
            'app_id' => "wx52c91b0d11c576f1",
            'secret' => "67315809b433046685ff40735a8c557c",
            'token' => "",
            'aes_key' => "",
            'oauth' => [
                'scopes' => ['snsapi_login'],
                'callback' => "https://passport.artron.net/wechat/code?type=open&config=wechat&redirect=",
            ],
        ],
    ],

    /*
     * 小程序
     */
    'mini_program' => [
        'default' => [
            'app_id' => 'wx49bbe08c88598089',
            'secret' => '761a1e5617c5b854acf927d25501b87d',
            'token' => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
        ],
    ],

];
