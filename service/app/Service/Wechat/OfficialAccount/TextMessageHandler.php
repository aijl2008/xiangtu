<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2019/1/12
 * Time: 下午11:13
 */

namespace App\Service\Wechat\OfficialAccount;


use EasyWeChat\Kernel\Contracts\EventHandlerInterface;

class TextMessageHandler implements EventHandlerInterface
{
    public function handle($payload = null)
    {
        return $payload;
    }
}