<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Log;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    function index(Request $request)
    {
        $view = view('videos.index');
        $view->with('rows', Video::query()
            ->where('visibility', Video::VISIBILITY_ANY)
            ->when(
                $classification = $request->input('classification'),
                function (Builder $builder) use ($classification) {
                    return $builder->where('classification_id', $classification);
                }
            )
            ->when(
                $user = $request->user('wechat'),
                function (Builder $builder) use ($user) {
                    $builder->orWhere(
                        function (Builder $builder) use ($user) {
                            $builder
                                ->where('visibility', Video::VISIBILITY_ONLY_FOLLOWED)
                                ->whereHas(
                                    'followed',
                                    function (Builder $builder) use ($user) {
                                        $builder->where('followed_id', $user->id);
                                    }
                                );
                        }
                    );
                }
            )
            ->with('wechat')
            ->orderBy('id', 'desc')
            ->simplePaginate(15));
        $view->with('classification', $request->input('classification', 0));
        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Video $video)
    {
        return view("videos.show")
            ->with('row', $video)
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
