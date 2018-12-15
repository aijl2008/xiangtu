<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:36
 */

namespace App\Http\Controllers\My;


use App\Http\Controllers\Controller;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    function index()
    {
        $statistics = [
            'played_number_on_today' => Log::query()
                ->where('action', '播放')
                ->where('to_user_id', Auth::guard('wechat')->user->id)
                ->whereBetween('updated_at', [
                    date('Y-m-d'),
                    Carbon::now()->addHours(24)->format('Y-m-d')
                ])
                ->count('id'),
            'follower_on_today' => Log::query()
                ->where('action', '关注')
                ->where('to_user_id', Auth::guard('wechat')->user->id)
                ->whereBetween('updated_at', [
                    date('Y-m-d'),
                    Carbon::now()->addHours(24)->format('Y-m-d')
                ])
                ->count('id'),
            ''
        ];
        return view('my.statistics.index');
    }

    function video()
    {
        return view('my.statistics.video');
    }

    function follower()
    {
        return view('my.statistics.follower');
    }
}