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

class ProfileController extends Controller
{
    function update(\Illuminate\Http\Request $request)
    {
        $user = $request->user('api');
        $row = array();
        foreach ([
                     'name', 'avatar', 'email', 'mobile'
                 ] as $item) {
            if ($value = $request->input($item)) {
                $row[$item] = $value;
            }
        }
        if (empty($row)) {
            return Helper::error(-1, "无更新");
        }
        $user->update($row);
        return Helper::success();
    }
}