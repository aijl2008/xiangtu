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
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $view = view('my.videos.index');
        $video = $request->user('wechat')
            ->video()
            ->with('wechat')
            ->orderBy('id', 'desc');
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
        $data = $request->all();
        if (!$data['cover_url']) {
            $vod = new \App\Models\Vod();
            Log::warning("用户未上传封面");
            $data['cover_url'] = "https://{$_SERVER["SERVER_NAME"]}/images/video_default_cover.png";
            $vod->createSnapshotByTimeOffsetAsCover($data['file_id'], 1);
        }
        $video = $request->user('wechat')->video()->create($data);
        return Helper::success($video->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Video $video)
    {
        return view("videos.show")
            ->with('row', $video)
            ->with('related',
                Video::query()
                    ->where(
                        'wechat_id',
                        '<>',
                        $request->user('wechat')->id
                    )->take(4)
                    ->get()
            );
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