<?php

namespace App\Http\Controllers\Api;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($user = $request->user('api')) {
            $user_id = $user->id;
        } else {
            $user_id = 0;
        }
        $video = Video::query()
            ->when($classification = $request->input('classification'), function (Builder $queries) use ($classification, $user_id) {
                return $queries->where('classification_id', $classification);
            });
        $video->offset(0)->take(16);
        $videos = [];
        foreach ($video->get() as $item) {
            $row = $item->toArray();
            $wechat = $item->wechat->toArray();
            if (!empty($wechat)) {
                if ($user = $request->user('api')) {
                    $wechat['followed'] = $user->haveFollowed($item->wechat);
                } else {
                    $wechat['followed'] = false;
                }
            }
            $row['wechat'] = $wechat;
            if ($user = $request->user('api')) {
                $row['liked'] = $user->haveLiked($item);
            } else {
                $row['liked'] = false;
            }
            $videos[] = $row;
        }
        return Helper::success(new LengthAwarePaginator($videos, $video->count(), 16));

    }

    function show(Video $video)
    {
        $rows = $video->toArray();
        $rows['wechat'] = ($wechat = $video->wechat)->toArray();
        if ($user = Auth::guard('api')->user()) {
            $rows['wechat']['followed'] = $user->haveFollowed($wechat);
            $rows['liked'] = $user->haveLiked($video);
        } else {
            $rows['wechat']['followed'] = false;
            $rows['liked'] = false;
        }
        return Helper::success($rows);
    }
}
