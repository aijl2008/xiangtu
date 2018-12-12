<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/12
 * Time: 下午7:58
 */

namespace App\Http\Controllers;

use App\Helper;
use EasyWeChat\Factory;
use Illuminate\Http\Request;

class QRCodeController
{
    function miniProgram(Request $request)
    {
        $scene = $request->input('scene');
        if (!$scene) {
            return Helper::error(-1, "非法的scene");
        }
        $miniProgram = Factory::miniProgram(config('wechat.mini_program.default'));
        return $miniProgram->app_code->getUnlimit($scene);
    }
}