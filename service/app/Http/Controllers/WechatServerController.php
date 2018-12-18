<?php

namespace App\Http\Controllers;


use App\Models\Message;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;

class WechatServerController extends Controller
{
    function serve()
    {
        $config = config('wechat.mini_program.default');
        $app = Factory::miniProgram($config);
        $app->server->push(function ($message) use ($app) {
            Message::query()->create(
                [
                    'to_user_name' => $message["ToUserName"],
                    'from_user_name' => config("wechat.mini_program.default.app_id") . '|' . $message["FromUserName"],
                    'create_time' => $message["CreateTime"],
                    'msg_type' => $message["MsgType"],
                    'content' => $message["Content"] ?? '',
                    'pic_url' => $message["PicUrl"] ?? '',
                    'media_id' => $message["MediaId"] ?? '',
                    'title' => $message["Title"] ?? '',
                    'app_id' => $message["AppId"] ?? '',
                    'page_path' => $message["PagePath"] ?? '',
                    'thumb_url' => $message["ThumbUrl"] ?? '',
                    'thumb_media_id' => $message["ThumbMediaId"] ?? '',
                    'event' => $message["Event"] ?? '',
                    'session_from' => $message["SessionFrom"] ?? ''
                ]
            );
            $app->customer_service->message(new Text("您输入的是：" . $message['Content']))->to($message['FromUserName'])->send();
        });
        return $app->server->serve();
    }
}
