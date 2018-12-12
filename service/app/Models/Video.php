<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
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
        'published_at'
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

    function liker()
    {
        return $this->belongsToMany(Wechat::class);
    }

    function followed()
    {
        return $this->hasMany(VideoWechat::class, 'video_id', 'id');
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
