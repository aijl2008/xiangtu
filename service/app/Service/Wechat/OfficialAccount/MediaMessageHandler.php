<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2019/1/12
 * Time: 下午11:14
 */

namespace App\Service\Wechat\OfficialAccount;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;

class MediaMessageHandler implements EventHandlerInterface
{
    public function handle($payload = null)
    {
        return $payload;
    }
}