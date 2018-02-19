<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\SpecificationsService;

class SpecificationsController extends Controller
{
    // 静态方法
    private static $specificationsService = null;

    // 防注入
    public function __construct(SpecificationsService $specificationsService)
    {
        self::$specificationsService = $specificationsService;
    }

    // 产品规格
    public function index()
    {
        // 查询列表
        $specificationsLists = self::$specificationsService->getAll();

        $count = self::$specificationsService->count();

        return view('admin.specifications.index', [
            'specifications' => $specificationsLists,
            'count' => $count ?? 0
        ]);
    }

}
