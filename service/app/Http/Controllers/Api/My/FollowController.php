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
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FollowController extends Controller
{
    function index(Request $request)
    {
        return Helper::success(
            call_user_func(function (Authenticatable $user) {
                if (!$user) {
                    return new LengthAwarePaginator([], 0, 20);
                }
                return $user->followed()->with(
                    [
                        'video' => function (HasMany $query) {
                            return $query->orderBy('id', 'desc')->take(10);
                        }
                    ]
                )->paginate(20);
            },
                $request->user('api')
            )
        );
    }

    function store(Request $request)
    {
        $user = $request->user('api');
        $followed = Wechat::query()->find($request->input('wechat_id'));
        if (!$followed) {
            return Helper::error(-1, "不存在的用户");
        }
        if ($user->followed()->where("followed_id", $request->input('wechat_id'))->count() > 0) {
            return Helper::error(-1, "您已经关注过了");
        }
        $user->followed()->attach($request->input('wechat_id'));
        return Helper::success(
            [
                'followed' => $followed
            ]
        );
    }

    function destroy(Request $request, $user_id)
    {
        $user = $request->user('api');
        $user->followed()->detach($user_id);
        return Helper::success(
            [
                'followed' => $user_id
            ]
        );
    }
}