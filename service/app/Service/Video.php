<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/22
 * Time: 下午1:19
 */

namespace App\Service;


use App\Models\Vod;
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class Video
{
    function paginate(Wechat $Wechat = null, $classification = 0, $take = 16)
    {
        if ($Wechat) {
            $user_id = $Wechat->id;
        } else {
            $user_id = 0;
        }
        $video = \App\Models\Video::query()
            ->when($classification, function (Builder $queries) use ($classification, $user_id) {
                return $queries->where('classification_id', $classification);
            });
        $video->offset(0)->take($take);
        $videos = [];
        foreach ($video->get() as $item) {
            $row = $item->toArray();
            $wechat = $item->wechat->toArray();
            if (!empty($wechat)) {
                if ($Wechat) {
                    $wechat['followed'] = $Wechat->haveFollowed($item->wechat);
                } else {
                    $wechat['followed'] = false;
                }
            } else {
                $wechat['followed'] = false;
            }
            $row['wechat'] = (object)$wechat;
            if ($Wechat) {
                $row['liked'] = $Wechat->haveLiked($item);
            } else {
                $row['liked'] = false;
            }
            $videos[] = (object)$row;
        }
        return new LengthAwarePaginator($videos, $video->count(), $take);
    }

    function show(\App\Models\Video $video, Wechat $Wechat = null)
    {
        $rows = (object)$video->toArray();
        $rows->wechat = (object)($wechat = $video->wechat)->toArray();
        if ($Wechat) {
            $rows->wechat->followed = $Wechat->haveFollowed($wechat);
            $rows->liked = $Wechat->haveLiked($video);
        } else {
            $rows->wechat->followed = false;
            $rows->liked = false;
        }
        return $rows;
    }

    /**
     * @param array $data
     * @param Wechat $Wechat
     * @return array
     */
    function store(Array $data, Wechat $Wechat)
    {
        if (!$data['cover_url']) {
            $vod = new Vod();
            Log::warning("用户未上传封面");
            $data['cover_url'] = "https://{$_SERVER["SERVER_NAME"]}/images/video_default_cover.png";
            $vod->createSnapshotByTimeOffsetAsCover($data['file_id'], 1);
        }
        $video = $Wechat->video()->create($data);
        return $video->toArray();
    }
}