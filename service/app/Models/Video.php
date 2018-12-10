<?php

namespace App\Models;

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
}
