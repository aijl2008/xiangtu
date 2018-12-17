<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:36
 */

namespace App\Http\Controllers\My;


use App\Http\Controllers\Controller;
use App\Models\FollowerReport;
use App\Models\VideoReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    function index()
    {
        $user = Auth::guard('wechat')->user();
        $followers = FollowerReport::query()
            ->where('wechat_id', $user->id)
            ->where('date', '>', date('Y-m-d', time() - 3600 * 24 * 8))
            ->groupBy('date')
            ->select(DB::raw(
                'date, 
                count(id) as number'
            ))->get();
        $play = VideoReport::query()
            ->where('wechat_id', $user->id)
            ->where('date', '>', date('Y-m-d', time() - 3600 * 24 * 8))
            ->groupBy('date')
            ->select(DB::raw(
                'date, 
                count(id) as number'
            ))->get();
        return view('my.statistics.index')
            ->with('followers', $followers)
            ->with('play', $play);
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