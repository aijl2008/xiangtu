<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/15
 * Time: 下午4:03
 */

namespace App\Service;


use App\Helper;
use App\Models\Log;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;

class Like
{
    protected $video;
    protected $user;

    function __construct(Video $video, Model $user)
    {
        $this->video = $video;
        $this->user = $user;

    }

    function toggle()
    {
        if (!$this->video) {
            return Helper::error(-1, "视频不存在");
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
                "已取消"
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
                "已收藏"
            );
        }
    }
}