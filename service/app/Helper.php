<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/21
 * Time: 19:46
 */

namespace App;


class Helper
{
    static function uid()
    {
        return "aaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
    }

    static function success($data = "")
    {
        return [
            'code' => 0,
            'data' => $data
        ];
    }

    static function error($code, $message, $data = "")
    {
        return [
            'code' => $code,
            'msg' => $message,
            'data' => $data
        ];
    }
}