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
        return Wechat::query()->with([
            'video' => function (HasMany $builder) {
                $builder->orderBy('id', 'desc')->limit(3);
            }
        ])->find($id);
    }
}
