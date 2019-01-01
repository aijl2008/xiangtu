<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/12
 * Time: 下午7:58
 */

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Video;
use App\Models\Wechat;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class QRCodeController
{
    function video(Request $request)
    {

        $scene = trim($request->input('scene'));
        if (!$scene) {
            return Helper::error(-1, "请指定scene");
        }
        $page = trim($request->input('page'));
        if (!$page) {
            return Helper::error(-1, "请指定page");
        }
        $video = Video::query()->find($scene);
        if (!$video) {
            return Helper::error(-1, "非法的scene");
        }
        /**
         * $canvas
         */
        $canvas = Image::canvas(720, 650, '#ffffff');

        /**
         * cover
         */
        $cover = Image::make($video->cover_url);
        $cover->resize(720, 480);
        $canvas->insert($cover);
        $canvas->text(str_limit($video->title, 17, ''), 50, 50, function ($font) {
            $font->file(base_path('/public/images/hei.ttf'));
            $font->size(36);
            $font->color('#ffffff');
        });

        /**
         * qr_code
         */
        $miniProgram = Factory::miniProgram(config('wechat.mini_program.default'));
        $response = $miniProgram->app_code->getUnlimit($scene, [
            "path" => $page
        ]);
        if (!$response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            return Helper::error(-1, "创建失败");
        }
        $qrcode = Image::make($response->getBodyContents());
        $qrcode->resize(160, 160);
        $canvas->insert($qrcode, 'bottom-right', 10, 10);

        /**
         * fingerprint
         */
        $fingerprint = Image::make(base_path('/public/images/fingerprint.png'));
        $fingerprint->resize(80, 80);
        $canvas->insert($fingerprint, 'bottom-left', 25, 25);
        $canvas->text('常按识别二维码即可播放视频', 120, 600, function ($font) {
            $font->file(base_path('/public/images/hei.ttf'));
            $font->size(32);
            $font->color('#333');
        });
        return $canvas->response();
    }


    function user(Request $request)
    {

        $scene = trim($request->input('scene'));
        if (!$scene) {
            return Helper::error(-1, "请指定scene");
        }
        $page = trim($request->input('page'));
        if (!$page) {
            return Helper::error(-1, "请指定page");
        }
        $wechat = Wechat::query()->find($scene);
        if (!$wechat) {
            return Helper::error(-1, "非法的scene");
        }
        /**
         * $canvas
         */
        $canvas = Image::canvas(720, 650, '#ffffff');

        /**
         * avatar
         */
        $avatar = Image::make($wechat->avatar);
        $avatar->resize(720, 720);
        $avatar->crop(720, 480);
        $canvas->insert($avatar);
        $canvas->text(str_limit($wechat->nickname, 17, ''), 50, 50, function ($font) {
            $font->file(base_path('/public/images/hei.ttf'));
            $font->size(36);
            $font->color('#ffffff');
        });

        /**
         * qr_code
         */
        $miniProgram = Factory::miniProgram(config('wechat.mini_program.default'));
        $response = $miniProgram->app_code->getUnlimit($scene, [
            'path' => $page
        ]);
        if (!$response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            return Helper::error(-1, "创建失败");
        }
        $qrcode = Image::make($response->getBodyContents());
        $qrcode->resize(160, 160);
        $canvas->insert($qrcode, 'bottom-right', 10, 10);

        /**
         * fingerprint
         */
        $fingerprint = Image::make(base_path('/public/images/fingerprint.png'));
        $fingerprint->resize(80, 80);
        $canvas->insert($fingerprint, 'bottom-left', 25, 25);
        $canvas->text('常按识别图片', 120, 600, function ($font) {
            $font->file(base_path('/public/images/hei.ttf'));
            $font->size(36);
            $font->color('#333');
        });
        return $canvas->response();
    }
}