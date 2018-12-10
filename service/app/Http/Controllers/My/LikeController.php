<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:37
 */

namespace App\Http\Controllers\My;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index(Request $request)
    {
        $view = view('my.liked.index');
        $video = $request->user('wechat')->liked()->with('wechat')->orderBy('id', 'desc');
        $view->with('rows', $video->paginate());
        $view->with('classification', $request->input('classification', 0));
        return $view;
    }
}