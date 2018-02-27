<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Request;

class CommonController extends AdminController
{
    //
    public function upload(Request $request)
    {
        dd($request->all);
    }
}
