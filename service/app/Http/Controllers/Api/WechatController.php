<?php

namespace App\Http\Controllers\Api;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function recommend()
    {
        return Helper::success(
            Wechat::query()->has('video')->with(
                [
                    'video' => function (HasMany $query) {
                        $query->orderBy('updated_at', 'desc')->take(6);
                    }
                ]
            )->paginate(16)
        );

    }
}
