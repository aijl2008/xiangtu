<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Log;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    function index(Request $request)
    {
        $view = view('videos.index');
        $view->with('rows', (new \App\Service\Video())->paginate($request->user('wechat'), $request->input('classification'), 15));
        $view->with('classification', $request->input('classification', 0));
        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(\App\Service\Video $videoService, Video $video)
    {
        return view("videos.show")
            ->with('row', $videoService->show($video, Auth::guard('wechat')->user()))
            ->with('related',
                Video::query()
                    ->where(
                        'classification_id',
                        $video->classification_id
                    )
                    ->where('id', '<>', $video->id)
                    ->take(4)
                    ->get()
            );
    }

    /**
     * 记录播放次数
     * @param Video $video
     * @return array
     */
    public function play(Video $video)
    {
        $video->increment('played_number');
        $user = Auth::guard('wechat')->user();
        if ($user) {
            Log::query()->create(
                [
                    'action' => '播放',
                    'from_user_id' => $user->id,
                    'video_id' => $video->id,
                    'message' => $user->nickname . '播放了视频' . $video->id
                ]
            );
        }
        return Helper::success();
    }
}
