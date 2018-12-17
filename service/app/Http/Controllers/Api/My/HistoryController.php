<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:30
 */

namespace App\Http\Controllers\Api\My;


use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    function index(Request $request)
    {
        return Helper::success(
            (new Log())->footprint($request->user('api')->id)->paginate(16)
        );
    }
}