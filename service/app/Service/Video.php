<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/22
 * Time: 下午1:19
 */

namespace App\Service;


use App\Models\Task;
use App\Models\Vod;
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Builder;
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
            ->with('wechat')
            ->when($classification, function (Builder $queries) use ($classification, $user_id) {
                return $queries->where('classification_id', $classification);
            })
            ->orderBy('id', 'desc');
        $Paginate = $video->simplePaginate();
        foreach ($Paginate as $item) {
            if (!empty($item->wechat->toArray())) {
                $item->wechat->setAttribute('followed', $Wechat ? $Wechat->haveFollowed($item->wechat) : false);
            } else {
                $item->wechat->setAttribute('followed', false);
            }
            $item->setAttribute('liked', $Wechat ? $Wechat->haveLiked($item) : false);
        }
        return $Paginate;
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
        if (strtolower(pathinfo($data['url'])['extension']) != 'mp4') {
            $data['status'] = 0;
            $vod = new Vod();
            $task = $vod->convertVodFile($data['file_id']);
            Task::query()->create(
                [
                    'file_id' => $data['file_id'],
                    'code' => $task->code,
                    'code_desc' => $task->codeDesc,
                    'message' => $task->message
                ]
            );
        } else {
            $data['status'] = 1;
            if (!$data['cover_url']) {
                $vod = new Vod();
                Log::warning("用户未上传封面");
                $data['cover_url'] = "https://{$_SERVER["SERVER_NAME"]}/images/video_default_cover.png";
                $task = $vod->createSnapshotByTimeOffsetAsCover($data['file_id'], 1);
                Task::query()->create(
                    [
                        'file_id' => $data['file_id'],
                        'code' => $task->code,
                        'code_desc' => $task->codeDesc,
                        'message' => $task->message
                    ]
                );
            }

        }
        $video = $Wechat->video()->create($data);
        return $video->toArray();
    }
}