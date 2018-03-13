<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    //
    public function index()
    {
        return view('admin.banner.index');
    }
}
