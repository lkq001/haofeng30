<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\CommonService;
use App\Service\ProductWarehouseService;
use Illuminate\Http\Request;

class ProductWarehouseController extends Controller
{
    // 静态方法
    private static $productWarehouseService = null;
    private static $commmonService = null;

    /**
     * ProductWarehouseController constructor.
     * @param ProductWarehouseService $productWarehouseService
     * @param CommonService $commonService
     */
    public function __construct(ProductWarehouseService $productWarehouseService, CommonService $commonService)
    {
        self::$productWarehouseService = $productWarehouseService;
        self::$commmonService = $commonService;
    }

    //
    public function index(Request $request)
    {
        // 产品分类
        $productCategoryLists = self::$productWarehouseService->getProductCategory();

        return view('admin.productWarehouse.index', [
            'productCategoryLists' => $productCategoryLists
        ]);
    }

    public function store(Request $request)
    {
        dd($request->file('img'));
        return $request->all();
    }

    public function upload()
    {
        dd(123);
    }
}
