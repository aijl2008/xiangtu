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
        return Helper::success(Video::query()
            ->when($classification = $request->input('classification'), function (Builder $queries) use ($classification) {
                return $queries->where('classification_id', $classification);
            })
            ->with('wechat')
            ->orderBy('id', 'desc')
            ->paginate(20));
    }
}
