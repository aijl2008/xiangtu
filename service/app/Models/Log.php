<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/12
 * Time: 下午4:49
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'action',
        'from_user_id',
        'to_user_id',
        'video_id',
        'message',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'formatted_message'
    ];

    function footprint($id)
    {
        return $this->where('from_user_id', $id)
            ->where('action', '播放');
    }

    function from_user()
    {
        return $this->belongsTo(Wechat::class, 'from_user_id')->withDefault();
    }

    function log($action, $from_user_id = 0, $to_user_id = 0, $video_id = 0, $message = '')
    {
        $this->newQuery()->create(
            [
                'action' => $action,
                'from_user_id' => $from_user_id,
                'to_user_id' => $to_user_id,
                'video_id' => $video_id,
                'message' => $message
            ]
        );
    }

    function getFormattedMessageAttribute()
    {
        if (!isset($this->attributes["message"]) || !$this->attributes["message"]) {
            return "";
        }
        if (substr($this->attributes["message"], 0, 10) == 'stdClass::') {
            return "<pre>{$this->attributes["message"]}</pre>";
        }
        if (preg_match("/\[([^\[]+)](.+)/", $this->attributes["message"], $match)) {
            $result = new \WhichBrowser\Parser($match[2]);
            return $match[1] . " " . $result->toString();
        }
        return $this->attributes["message"];
    }
}