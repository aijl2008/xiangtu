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
use App\Models\Video;
use App\Models\VideoReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    function index()
    {
        $user = Auth::guard('wechat')->user();
        $followers = $this->fill();
        foreach (FollowerReport::query()
                     ->where('wechat_id', $user->id)
                     ->where('date', '>', date('Y-m-d', time() - 3600 * 24 * 8))
                     ->groupBy('date')
                     ->select(DB::raw(
                         'date, 
                count(id) as number'
                     ))->get() as $item) {
            if (array_key_exists($item->date, $followers)) {
                $followers[$item->date] = $item->number;
            }
        }
        $play = $this->fill();
        foreach (VideoReport::query()
                     ->where('wechat_id', $user->id)
                     ->where('date', '>', date('Y-m-d', time() - 3600 * 24 * 8))
                     ->groupBy('date')
                     ->select(DB::raw(
                         'date, 
                count(id) as number'
                     ))->get() as $item) {
            if (array_key_exists($item->date, $play)) {
                $play[$item->date] = $item->number;
            }
        }

        $upload = $this->fill();
        foreach (Video::query()
                     ->where('wechat_id', $user->id)
                     ->where('created_at', '>', date('Y-m-d', time() - 3600 * 24 * 8))
                     ->groupBy(DB::raw("left(created_at, 10)"))
                     ->select(DB::raw(
                         'left(created_at,10) as date, 
                count(id) as number'
                     ))->get() as $item) {
            if (array_key_exists($item->date, $upload)) {
                $upload[$item->date] = $item->number;
            }
        }
        return view('my.statistics.index')
            ->with('follower_date', json_encode(array_keys($followers)))
            ->with('follower_value', json_encode(array_values($followers)))
            ->with('play_date', json_encode(array_keys($play)))
            ->with('play_value', json_encode(array_values($play)))
            ->with('upload_date', json_encode(array_keys($upload)))
            ->with('upload_value', json_encode(array_values($upload)));
    }

    function fill()
    {
        $ret = [];
        for ($i = time() - 3600 * 24 * 6; $i <= time(); $i = $i + 3600 * 24) {
            $ret[date('Y-m-d', $i)] = 0;
        }
        return $ret;
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