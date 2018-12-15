<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    function index(Request $request)
    {
        $view = view('videos.index');
        $view->with('rows', Video::query()
            ->where('visibility', Video::VISIBILITY_ANY)
            ->when(
                $classification = $request->input('classification'),
                function (Builder $builder) use ($classification) {
                    return $builder->where('classification_id', $classification);
                }
            )
            ->when(
                $user = $request->user('wechat'),
                function (Builder $builder) use ($user) {
                    $builder->orWhere(
                        function (Builder $builder) use ($user) {
                            $builder
                                ->where('visibility', Video::VISIBILITY_ONLY_FOLLOWED)
                                ->whereHas(
                                    'followed',
                                    function (Builder $builder) use ($user) {
                                        $builder->where('followed_id', $user->id);
                                    }
                                );
                        }
                    );
                }
            )
            ->with('wechat')
            ->orderBy('id', 'desc')
            ->paginate(16));
        $view->with('classification', $request->input('classification', 0));
        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Video $video)
    {
        $video->increment('played_number');
        return view("videos.show")
            ->with('row', $video)
            ->with('related',
                Video::query()
                    ->where(
                        'classification_id',
                        $video->classification_id
                    )
                    ->where('id', '<>', $video->id)
                    ->take(4)
                    ->get()
            );
    }
}
