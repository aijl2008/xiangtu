<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/15
 * Time: 下午4:03
 */

namespace App\Service;


use App\Helper;
use App\Models\FollowedWechat;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

class Follow
{
    protected $target;
    protected $user;

    function __construct(Model $target = null, Model $user = null)
    {
        $this->target = $target;
        $this->user = $user;

    }

    function toggle()
    {
        if (!$this->target) {
            return Helper::error(-1, "用户不存在");
        }
        if ($this->target->id == $this->user->id) {
            return Helper::error(-1, "不允许关注自已");
        }
        if ($this->user->followed()->where("wechat_id", $this->target->id)->count() > 0) {
            Log::query()->create(
                [
                    'action' => '取消关注',
                    'from_user_id' => $this->user->id,
                    'to_user_id' => $this->target->id,
                    'message' => $this->user->nickname . '取消关注了' . $this->target->nickname
                ]
            );
            $this->user->followed()->where('wechat_id', $this->target->id)->delete();
            $this->user->decrement('followed_number');
            $this->target->decrement('be_followed_number');
            return Helper::success(
                [
                    'be_followed_number' => $this->target->be_followed_number
                ],
                "已取消关注"
            );
            return Helper::error(-1, "您已经关注过了");
        } else {
            $FollowedWechat = new FollowedWechat([
                "wechat_id" => $this->target->id,
                "followed_id" => $this->user->id
            ]);
            $this->user->followed()->save($FollowedWechat);
            Log::query()->create(
                [
                    'action' => '关注',
                    'from_user_id' => $this->user->id,
                    'to_user_id' => $this->target->id,
                    'message' => $this->user->nickname . '关注了' . $this->target->nickname
                ]
            );
            $this->user->increment('followed_number');
            $this->target->increment('be_followed_number');
            return Helper::success(
                [
                    'be_followed_number' => $this->target->be_followed_number
                ],
                "关注成功"
            );
        }
    }
}