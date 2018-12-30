<?php

namespace App\Http\Controllers\Api;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Wechat;
use App\Service\Video;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return array
     */
    public function index()
    {
        return Helper::success(Wechat::query()
            ->orderBy('id', 'desc')
            ->paginate(20));
    }

    public function recommend(Request $request)
    {
        $wechat = $request->user("api");
        $wechats = Wechat::query()
            ->has('video', '>', 3)
            ->paginate(16);
        foreach ($wechats as $item) {
            $item->followed = $item->haveFollower($wechat);
            $item->video = $item->video()->take(3)->get();
        }
        return Helper::success(
            $wechats
        );

    }

    function show(Request $request, $id)
    {
        $wechat = Wechat::query()->findOrFail($id);
        if ($user = $request->user('api')) {
            $wechat->followed = $user->haveFollowed($wechat);
        }
        $wechat->video = (new Video())->paginate($user, null, $id, 16, false);
        return Helper::success(
            $wechat
        );
    }
}
