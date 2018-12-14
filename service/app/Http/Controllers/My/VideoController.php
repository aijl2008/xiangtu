<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:37
 */

namespace App\Http\Controllers\My;


use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $view = view('my.videos.index');
        $video = Video::query()->with('wechat')->orderBy('id', 'desc');
        $view->with('rows', $video->paginate());
        $view->with('classification', $request->input('classification', 0));
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function create()
    {
        return view('my.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param VideoRequest $request
     * @return array
     */
    public function store(VideoRequest $request)
    {
        $video = $request->user('wechat')->video()->create($data = $request->all());
        $vod = new \App\Models\Vod();
        if (!$video->cover_url) {
            $vod->createSnapshotByTimeOffsetAsCover($video->file_id, 1);
        }
        return Helper::success($video->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Video $video)
    {
        return view("my.videos.show")->with('row', $video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}