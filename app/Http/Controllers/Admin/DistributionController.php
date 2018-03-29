<?php

namespace App\Http\Controllers\Admin;

use App\Service\DistributionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistributionController extends Controller
{
    // 静态方法
    public static $distributionService = null;

    public function __construct(
        DistributionService $distributionService
    )
    {
        self::$distributionService = $distributionService;
    }

    //
    public function index(Request $request)
    {
        $lists = self::$distributionService->getCommonProduct([], config('config.page_size_l'));
        $count = self::$distributionService->count();

        return view('admin.distribution.index', [
            'count' => $count,
            'lists' => $lists
        ]);
    }

}
