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
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Model;

class Follow
{
    protected $target;
    protected $user;

    function __construct(Model $target =null, Model $user = null)
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
            $this->user->followed()->delete($this->target);
            $this->target->decrement('followed_number');
            return Helper::success(
                [
                    'followed_number' => $this->target->followed_number
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
            $this->target->increment('followed_number');
            return Helper::success(
                [
                    'followed_number' => $this->target->followed_number
                ],
                "关注成功"
            );
        }


        if ($this->video->wechat_id == $this->user->id) {
            return Helper::error(-1, "不允许收藏自已的视频");
        }
        if ($this->user->liked()->where("video_id", $this->video->id)->count() > 0) {
            $this->user->liked()->detach($this->video->id);
            Log::query()->create(
                [
                    'action' => '取消收藏',
                    'from_user_id' => $this->user->id,
                    'to_user_id' => $this->video->wechat->id,
                    'message' => $this->user->nickname . '取消收藏了' . $this->video->wechat->nickname . '的视频'
                ]
            );
            $this->video->decrement('liked_number');
            return Helper::success(
                [
                    'liked_number' => $this->video->liked_number
                ],
                "已取消收藏"
            );
            return Helper::error(-1, "已取消收藏");
        } else {
            $this->user->liked()->attach($this->video->id);
            $this->video->increment('liked_number');
            Log::query()->create(
                [
                    'action' => '收藏',
                    'from_user_id' => $this->user->id,
                    'to_user_id' => $this->video->wechat->id,
                    'message' => $this->user->nickname . '收藏了' . $this->video->wechat->nickname . '的视频'
                ]
            );
            return Helper::success(
                [
                    'liked_number' => $this->video->liked_number
                ],
                "收藏成功"
            );
        }
    }
}