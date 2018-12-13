<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:29
 */

namespace App\Http\Controllers\Api\My;


use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    function index(Request $request)
    {
        $user = $request->user('api');
        return Helper::success(
            Video::query()
                ->whereHas('wechat.follower', function (Builder $builder) use ($user) {
                    $builder->where('followed_id', $user->id);
                })
                ->with('wechat')
                ->orderBy('id', 'desc')
                ->paginate(16)
        );
    }

    function store(Request $request)
    {
        $user = $request->user('api');
        $followed = Wechat::query()->find($request->input('wechat_id'));
        if (!$followed) {
            return Helper::error(-1, "不存在的用户");
        }
        if ($user->followed()->where("wechat_id", $request->input('wechat_id'))->count() > 0) {
            return Helper::error(-1, "您已经关注过了");
        }
        $user->followed()->create([
            "wechat_id" => $request->input('wechat_id')
        ]);
        return Helper::success(
            [
                'followed' => $user->followed()->count()
            ]
        );
    }

    function destroy(Request $request, $user_id)
    {
        $user = $request->user('api');
        $user->followed()->where("wechat_id", $user_id)->delete();
        return Helper::success(
            [
                'followed' => $user->followed()->count()
            ]
        );
    }
}