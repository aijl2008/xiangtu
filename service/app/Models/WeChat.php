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


    function liked()
    {
        return $this->belongsToMany(Video::class)->withTimestamps();
    }

    /**
     * 我关注的人的视频
     */
    function fansVideo()
    {
        return $this->hasManyThrough(Video::class, FollowedWechat::class);
    }

    /**
     * 我关注的
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
     * 关注我的
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function follower()
    {
        return $this->hasMany(FollowedWechat::class, 'wechat_id', 'id');
    }

    function haveFollowed(Wechat $wechat)
    {
        return $this->followed()->where('wechat_id', $wechat->id)->count() > 0;
    }

    function haveLiked(Video $video)
    {

        if ($this->newQuery()->whereHas('liked', function (Builder $query) use ($video) {
                $query->where('video_id', $video->id);
            })->count() > 0) {
            return true;
        }
        return false;
    }

    function video()
    {
        return $this->hasMany(Video::class);
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
