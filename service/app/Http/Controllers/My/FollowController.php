<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:37
 */

namespace App\Http\Controllers\My;


use App\Http\Controllers\Controller;
use App\Models\Wechat;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        $view = view('my.followed.index');
        $user = $request->user('wechat')->followed();
        $recommended = false;
        if ($user->count() == 0) {
            $user = Wechat::query()->has('video')->inRandomOrder()->limit(10);
            $recommended = true;
        }
        $user->with(
            [
                'video' => function (HasMany $query) {
                    return $query->orderBy('id', 'desc')->take(4);
                }
            ]
        );
        if ($recommended) {
            return $view->with('rows', new LengthAwarePaginator($user->get(), 0, 20));
        } else {
            return $view->with('rows', $user->paginate());
        }

    }
}