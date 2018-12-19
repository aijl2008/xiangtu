<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    const VISIBILITY_ANY = 1;
    const VISIBILITY_ONLY_FOLLOWED = 2;
    const VISIBILITY_ONLY_ME = 3;
    public $timestamps = true;
    protected $fillable = [
        "wechat_id",
        "title",
        "url",
        "cover_url",
        "file_id",
        "uploaded_at",
        "played_number",
        "liked_number",
        "shared_wechat_number",
        "shared_moment_number",
        "visibility",
        "classification_id",
        "status"
    ];

    protected $appends = [
        'published_at',
        'humans_published_at'
    ];

    function getStatusOption()
    {
        return [
            1 => '正常',
            0 => '不可用',
        ];
    }

    function wechat()
    {
        return $this->belongsTo(Wechat::class);
    }

    function classification()
    {
        return $this->belongsTo(Classification::class)->withDefault();
    }

    function liker()
    {
        return $this->belongsToMany(Wechat::class);
    }

    function followed()
    {
        //return $this->hasMany(VideoWechat::class, 'video_id', 'id');
        return $this->hasManyThrough(FollowedWechat::class, VideoWechat::class, 'wechat_id', 'wechat_id', 'wechat_id');
    }

    function getHumansPublishedAtAttribute()
    {
        return $this->attributes['humans_published_at'] = Carbon::parse($this->attributes['updated_at'])->diffForHumans();;
    }

    function getPublishedAtAttribute()
    {
        $diff = Carbon::parse($this->attributes['updated_at'])->diffInDays(Carbon::now());
        if ($diff == 0) {
            $this->attributes['published_at'] = '今天';
        } elseif ($diff == 1) {
            $this->attributes['published_at'] = '昨天';
        } elseif ($diff < 8) {
            $this->attributes['published_at'] = '7天以内';
        } else {
            $this->attributes['published_at'] = '7天以上';
        }
        return $this->attributes['published_at'];
    }
}
