<?php
return [
    /**
     * 腾讯云
     */
    'cloud' => [
        'app_id' => '1258107170',
        'api' => [
            'default' => [
                'secret_id' => 'AKIDyrfTFpeibYP6dFMyBGDIQzTs7KmIRw8J',
                'secret_key' => "AHTelhTJ8Da2JsTy2RkWM3oPJ6pSZYTN",
            ]
        ]
    ],
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
            'app_id' => "wxb783a4e5aad0e5bc",
            'secret' => "8d14a3b9d67ac84abaf135a012086dec",
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
            'app_id' => 'wxbe20d80072eaf2d3',
            'secret' => '0cfb1809377ba6cd225c21968381e98c',
            'token' => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/../../storage/logs/wechat.log',
            ]
        ],
    ],

];
