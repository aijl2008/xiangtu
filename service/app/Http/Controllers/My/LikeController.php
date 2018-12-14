<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:37
 */

namespace App\Http\Controllers\My;


use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index(Request $request)
    {
        $view = view('my.liked.index');
        $video = $request->user('wechat')->liked()->with('wechat')->orderBy('id', 'desc');
        $view->with('rows', $video->paginate());
        $view->with('classification', $request->input('classification', 0));
        return $view;
    }

    function store(Request $request)
    {
        $user = $request->user('wechat');
        $video = Video::query()->find($request->input('video_id'));
        if (!$video) {
            return Helper::error(-1, "视频不存在");
        }
        if ($user->liked()->where("video_id", $video->id)->count() > 0) {
            $user->liked()->detach($video->id);
            return Helper::error(-1, "已取消收藏");
        }
        $user->liked()->attach($video->id);
        $video->update(
            [
                "liked_number" => $user->liked()->count()
            ]
        );
        return Helper::success(
            [
                'video' => $video,
                'liked_number' => $video->liked_number
            ],
            "收藏成功"
        );
    }
}