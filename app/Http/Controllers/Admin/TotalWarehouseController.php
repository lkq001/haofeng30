<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TotalWarehouseController extends Controller
{
    //
    public function index()
    {
        return view('admin.totalWarehouse.index');
    }
}
