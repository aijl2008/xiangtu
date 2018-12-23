<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Vod;

class TaskController extends Controller
{
    function index()
    {
        return view('admin.tasks.index')->with('rows', Task::query()->orderBy('id', 'desc')->paginate());
    }

    function show(Task $task){
        $vod = new Vod();
        dd($vod->getTaskInfo($task->task_id));
    }
}
