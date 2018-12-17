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
        'message'
    ];

    function footprint($id)
    {
        return $this->where('from_user_id', $id)
            ->where('action', '播放');
    }
}