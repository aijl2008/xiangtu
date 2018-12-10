<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function index(Request $request)
    {
        $view = view('videos.index');
        $view->with('rows', Video::query()
            ->when($classification = $request->input('classification'), function (Builder $queries) use ($classification) {
                return $queries->where('classification_id', $classification);
            })
            ->with('wechat')
            ->orderBy('id', 'desc')
            ->paginate(20));
        $view->with('classification', $request->input('classification', 0));
        return $view;
    }
}
