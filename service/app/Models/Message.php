<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'to_user_name',
        'from_user_name',
        'create_time',
        'msg_type',
        'event',
        'session_from',
        'content',
        'pic_url',
        'media_id',
        'title',
        'app_id',
        'page_path',
        'thumb_url',
        'thumb_media_id'
    ];
}