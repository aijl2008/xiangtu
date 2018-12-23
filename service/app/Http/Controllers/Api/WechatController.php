<?php

namespace App\Http\Controllers\Api;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
            ->simplePaginate(20));
    }

    public function recommend(Request $request)
    {
        $wechat = $request->user("api");
        $wechats = Wechat::query()->has('video')->with(
            [
                'video' => function (HasMany $query) {
                    $query->orderBy('updated_at', 'desc')->take(6);
                }
            ]
        )->simplePaginate(16);
        foreach ($wechats as $item) {
            $item->followed = $item->haveFollower($wechat);
        }
        return Helper::success(
            $wechats
        );

    }

    function show(Request $request, $id)
    {
        return Wechat::query()->with([
            'video' => function (HasMany $builder) {
                $builder->orderBy('id', 'desc')->limit(3);
            }
        ])->find($id);
    }
}
