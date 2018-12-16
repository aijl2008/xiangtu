<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;

class LogController extends Controller
{
    function index()
    {
        return view('admin.logs.index')->with('rows', Log::query()->orderBy('id', 'desc')->paginate());
    }
}
