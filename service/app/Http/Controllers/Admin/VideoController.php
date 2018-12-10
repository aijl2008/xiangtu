<?php
/**
 * Created by PhpStorm.
 * User: artron
 * Date: 2018/11/19
 * Time: 20:37
 */

namespace App\Http\Controllers\Admin;


use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Vod;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param $video
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.videos.index')->with('rows', Video::query()->orderBy('id', 'desc')->paginate());
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
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Video $video)
    {
        return view("admin.videos.show")->with('row', $video)->with('video', (new Vod())->getVideoInfo($video->file_id));
    }

    public function snapshot(Video $video)
    {
        $snapshot = (new Vod())->createSnapshotByTimeOffset($video->file_id);
        if ($snapshot->code == 0) {
            return Helper::success(
                [
                    'vodTaskId' => $snapshot->vodTaskId
                ]
            );
        }
        return Helper::error(-1, $snapshot->message);
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