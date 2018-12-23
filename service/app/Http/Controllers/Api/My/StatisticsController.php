<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:34
 */

namespace App\Http\Controllers\Api\My;


use App\Helper;
use App\Http\Controllers\Controller;
use App\Service\Statistics;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    function __invoke()
    {
        return Helper::success(
            (new Statistics())->make(Auth::guard('api')->user())
        );
    }

    function fill()
    {
        $ret = [];
        for ($i = time() - 3600 * 24 * 6; $i <= time(); $i = $i + 3600 * 24) {
            $ret[date('Y-m-d', $i)] = 0;
        }
        return $ret;
    }
}