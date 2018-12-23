<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Wechat extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'wechats';

    protected $fillable = [
        "open_id",
        "union_id",
        "avatar",
        "mobile",
        "nickname",
        "sex",
        "country",
        "province",
        "city",
        "status"
    ];

    function getAvatarAttribute()
    {
        return str_replace('http://', 'https://', $this->attributes['avatar']);
    }


    /**
     * 我关注的人
     * @param bool $returnUser
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    function followed($returnUser = false)
    {
        if (!$returnUser) {
            return $this->hasMany(FollowedWechat::class, 'followed_id', 'id');
        }
        return $this->hasManyThrough(
            Wechat::class,
            FollowedWechat::class,
            'followed_id',
            'id',
            null, 'wechat_id'
        );
    }

    /**
     * 关注我的人
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function follower()
    {
        return $this->hasMany(FollowedWechat::class, 'wechat_id', 'id');
    }


    /**
     * 我是否关注了某人
     * @param Wechat $wechat
     * @return bool
     */
    function haveFollowed(Wechat $wechat = null)
    {
        if (!$wechat) {
            return false;
        }
        return $this->followed()->where('wechat_id', $wechat->id)->count() > 0;
    }

    /**
     * 某人是否关注了我
     * @param Wechat $wechat
     * @return bool
     */
    function haveFollower(Wechat $wechat = null)
    {
        if (!$wechat) {
            return false;
        }
        return $this->follower()->where('wechat_id', $wechat->id)->count() > 0;
    }


    /**
     * 我的视频
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function video()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * 我收藏的视频
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    function liked()
    {
        return $this->belongsToMany(Video::class)->withTimestamps();
    }

    /**
     * 是否收藏过指定的视频
     * @param Video $video
     * @return bool
     */
    function haveLiked(Video $video)
    {
        if ($this->newQuery()->whereHas('liked', function (Builder $query) use ($video) {
                $query->where('video_id', $video->id);
            })->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * 我关注的人的视频
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    function fansVideo()
    {
        return $this->hasManyThrough(Video::class, FollowedWechat::class);
    }

    /**
     * 我的关注数
     * @return string
     */
    function getFollowedNumberAttribute()
    {
        if ($this->attributes['followed_number'] < 10) {
            return '  ' . $this->attributes['followed_number'];
        }
        if ($this->attributes['followed_number'] < 100) {
            return ' ' . $this->attributes['followed_number'];
        }
        if ($this->attributes['followed_number'] > 999) {
            return '999+';
        }
    }

    /**
     * 我的粉丝数
     * @return string
     */
    function getBeFollowedNumberAttribute()
    {
        if ($this->attributes['be_followed_number'] < 10) {
            return '  ' . $this->attributes['be_followed_number'];
        }
        if ($this->attributes['be_followed_number'] < 100) {
            return ' ' . $this->attributes['be_followed_number'];
        }
        if ($this->attributes['be_followed_number'] > 999) {
            return '999+';
        }
    }

    /**
     * 我的视频数
     * @return string
     */
    function getUploadedNumberAttribute()
    {
        if ($this->attributes['uploaded_number'] < 10) {
            return '  ' . $this->attributes['uploaded_number'];
        }
        if ($this->attributes['uploaded_number'] < 100) {
            return ' ' . $this->attributes['uploaded_number'];
        }
        if ($this->attributes['uploaded_number'] > 999) {
            return '999+';
        }
    }

    function updateRememberToken()
    {
    }

    function getStatusOption()
    {
        return [
            1 => '正常',
            0 => '不可用',
        ];
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {

    }

}
