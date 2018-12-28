<?php

namespace App\Http\Controllers;


use App\Models\Message;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Support\Facades\Log;

class WechatServerController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    function serve()
    {
        $config = config('wechat.mini_program.default');
        $app = Factory::miniProgram($config);
        try {
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
                $app->customer_service->message(new Text("当前没有客服在线，您可以留言，我们会尽快回复您"))->to($message['FromUserName'])->send();
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }

        return $app->server->serve();
    }
}
