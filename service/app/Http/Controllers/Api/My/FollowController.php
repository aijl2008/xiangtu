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
use App\Service\Follow;
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
        return (new Follow(
            Wechat::query()->find($request->input('wechat_id')),
            $request->user('api')
        ))->toggle();
    }

    function destroy(Request $request, $user_id)
    {
        return (new Follow(
            Wechat::query()->find($user_id),
            $request->user('api')
        ))->toggle();
    }
}