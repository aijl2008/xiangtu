<?php

namespace App\Http\Controllers\Api;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        return Helper::success(
            (new \App\Service\Video())
                ->paginate(
                    $request->user("api"),
                    $request->input('classification'),
                    $request->input('wechat_id'),
                    16,
                    false
                )
        );
    }

    function show(Video $video)
    {
        return Helper::success((new \App\Service\Video())->show($video, Auth::guard('api')->user()));
    }
}
