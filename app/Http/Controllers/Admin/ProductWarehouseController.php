<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\CommonService;
use App\Service\ProductWarehouseService;
use Validator;
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
        // 数据验证
        $data = $request->except('_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'pid' => 'required|int',
            'order_by' => 'required',
            'thumb' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否重复
        $getOne = self::$productWarehouseService->getOneInfo(['name' => $request->name]);
        if ($getOne) {
            return response()->json(['code' => 'SN202', 'message' => '数据已经存在']);
        }

        // 执行数据保存(调用service)
        $result = self::$productWarehouseService->store($data);

        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功']);
        }
        return response()->json(['code' => 'SN201', 'message' => '添加失败']);

    }

    public function upload()
    {
        dd(123);
    }
}
