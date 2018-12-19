<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wechat;

class UserController extends Controller
{
    function index()
    {
        return view('admin.users.index')
            ->with('rows', Wechat::query()
                ->orderBy('id', 'desc')
                ->simplePaginate());
    }
}
