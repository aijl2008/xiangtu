<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Video $video)
    {
        return view("videos.show")->with('row', $video);
    }
}
