<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inform extends Model
{
    protected $fillable = [
        "wechat_id","video_id","ips","content"
    ];
}
