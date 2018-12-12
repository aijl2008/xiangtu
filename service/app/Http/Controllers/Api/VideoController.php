<?php

namespace App\Http\Controllers\Api;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($user = $request->user('api')) {
            $user_id = $user->id;
        } else {
            $user_id = 0;
        }
        return Helper::success(Video::query()
            ->when($classification = $request->input('classification'), function (Builder $queries) use ($classification, $user_id) {
                return $queries->where('classification_id', $classification);
            })
            ->with('wechat')
            ->withCount([
                'liker' => function (Builder $query) use ($user_id) {
                    return $query->where('wechat_id', $user_id);
                }
            ])
            ->orderBy('id', 'desc')
            ->paginate(10)->appends('classification', $classification));
    }
}
