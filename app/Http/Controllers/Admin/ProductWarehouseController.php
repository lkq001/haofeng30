<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\CommonService;
use App\Service\ProductWarehouseService;
use App\Store\ProductWarehouseStore;
use Validator;
use Illuminate\Http\Request;

class ProductWarehouseController extends Controller
{
    // 静态方法
    private static $productWarehouseService = null;
    private static $commmonService = null;
    private static $productWarehouseStore = null;

    /**
     * ProductWarehouseController constructor.
     * @param ProductWarehouseService $productWarehouseService
     * @param CommonService $commonService
     * @param ProductWarehouseStore $productWarehouseStore
     */
    public function __construct(
        ProductWarehouseService $productWarehouseService,
        CommonService $commonService,
        ProductWarehouseStore $productWarehouseStore
    )
    {
        self::$productWarehouseService = $productWarehouseService;
        self::$commmonService = $commonService;
        self::$productWarehouseStore = $productWarehouseStore;
    }

    /**
     * 列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function index(Request $request)
    {
        // 产品分类
        $productCategoryLists = self::$productWarehouseService->getProductCategory();

        // 产品列表
        $productWarehouseLists = self::$productWarehouseService->getAll();

        // 数量
        $count = self::$productWarehouseService->count();

        return view('admin.productWarehouse.index', [
            'productCategoryLists' => $productCategoryLists,
            'productWarehouseLists' => $productWarehouseLists,
            'count' => $count
        ]);
    }

    /**
     * 添加
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function store(Request $request)
    {
        // 数据验证
        $data = $request->except('_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'pid' => 'required|int',
            'thumb' => 'required',
            'price' => 'required|numeric'
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

    /**
     * 修改排序
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function order(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'order_by' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 获取指定数据
        // 判断数据是否存在
        $info = self::$productWarehouseStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$productWarehouseStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);

    }

    /**
     * 添加页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function add()
    {
        // 产品分类
        $productCategoryLists = self::$productWarehouseService->getProductCategory();

        return view('admin.productWarehouse.add', [
            'productCategoryLists' => $productCategoryLists,
        ]);
    }

    /**
     * 修改状态
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function status(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'status' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否存在
        $info = self::$productWarehouseStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 2) {
            $status = 1;
        } else {
            $status = 2;
        }
        // 执行修改
        $res = self::$productWarehouseStore->update($request->id, ['status' => $status]);

        if ($res) {
            return response()->json(['code' => 'SN200', 'message' => '状态修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '状态修改失败!']);
    }

    /**
     * 删除数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function destroy(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否存在
        $info = self::$productWarehouseStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$productWarehouseStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }

    /**
     * 获取数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function edit(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 获取指定数据
        // 判断数据是否存在
        $productWarehouse = self::$productWarehouseService->getOneInfo(['id' => $request->id]);

        // 产品分类
        $productCategoryLists = self::$productWarehouseService->getProductCategory();
//        dd(collect($productWarehouse)->toArray());
        return view('admin.productWarehouse.edit', [
            'productCategoryLists' => $productCategoryLists,
            'productWarehouse' => $productWarehouse
        ]);
    }

    // 修改
    public function update(Request $request)
    {
        // 数据验证
        $data = $request->except('id', '_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|min:2',
            'pid' => 'required|int',
            'price' => 'required|numeric'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        if (empty($request->thumb) && empty($request->thumbOld)) {
            return response()->json(['code' => 'SN202', 'message' => '至少有一张图片']);
        }

        // 判断数据是否重复
        $getOne = self::$productWarehouseService->getOneInfo(['id' => $request->id]);
        if (!$getOne) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在']);
        }

        // 执行数据保存(调用service)
        $result = self::$productWarehouseService->update($request->id, $data);

        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功']);
        }
        return response()->json(['code' => 'SN201', 'message' => '添加失败']);
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function destroys(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => '批量删除参数错误,请联系管理员!']);
        }

        // 执行删除操作
        $destroyStatus = self::$productWarehouseStore->destroys($request->ids);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }

    /**
     * 批量修改状态
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function statusAll(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'status' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => '批量操作参数错误,请联系管理员!']);
        }

        // 执行修改操作
        $changeStatus = self::$productWarehouseStore->statusAll($request->ids, $request->status);

        if ($changeStatus) {
            return response()->json(['code' => 'SN200', 'message' => '批量操作数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '批量操作数据失败!']);
    }
}
