<?php

namespace App\Http\Controllers;

use App\Models\Wechat\OfficialAccount\OfficialAccount;
use App\Service\Wechat\OfficialAccount\EventMessageHandler;
use App\Service\Wechat\OfficialAccount\ImageMessageHandler;
use App\Service\Wechat\OfficialAccount\MediaMessageHandler;
use App\Service\Wechat\OfficialAccount\TextMessageHandler;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Message;
use Illuminate\Http\Request;

class OfficialAccountController extends Controller
{
    function server(Request $request, $app_id)
    {
        $OfficialAccount = OfficialAccount::query()->findOrFail($app_id);
        $app = Factory::officialAccount([
            'app_id' => $OfficialAccount->app_id,
            'secret' => $OfficialAccount->secret,
            'token' => $OfficialAccount->token,
            'aes_key' => $OfficialAccount->aes_key,
        ]);
        try {
            //
            $app->server->push(EventMessageHandler::class, Message::EVENT); // 图片消息
            $app->server->push(ImageMessageHandler::class, Message::IMAGE); // 图片消息
            $app->server->push(TextMessageHandler::class, Message::TEXT); // 文本消息
            $app->server->push(MediaMessageHandler::class, Message::VOICE | Message::VIDEO | Message::SHORT_VIDEO); // 当消息为 三种中任意一种都可触发
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }
        return $app->server->serve();
    }
}
