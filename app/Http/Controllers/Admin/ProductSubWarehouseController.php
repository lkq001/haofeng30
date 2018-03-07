<?php

namespace App\Http\Controllers\Admin;

use App\Service\ProductWarehouseService;
use App\Store\ProductSubWarehouseStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSubWarehouseController extends Controller
{
    // 静态方法
    private static $productWarehouseService = null;
    private static $productSubWarehouseService = null;
    private static $productSubWarehouseStore = null;

    // 防注入
    public function __construct(
        ProductWarehouseService $productWarehouseService,
        ProductSubWarehouseStore $productSubWarehouseStore
    )
    {
        self::$productWarehouseService = $productWarehouseService;
        self::$productSubWarehouseStore = $productSubWarehouseStore;
    }

    //
    public function index(Request $request)
    {
        $productSubWarehouseLists = self::$productSubWarehouseStore->getAll();
        return view('admin.productSubWarehouse.index', [
            'productSubWarehouseLists' => $productSubWarehouseLists
        ]);
    }

    /**
     * 执行添加
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function store(Request $request)
    {
        // 获取可添加数据
        $data = $request->except('_token');

        // 验证规则
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否重复
        $getOne = self::$productSubWarehouseStore->getOneInfoCount(['name' => $request->name]);
        if ($getOne) {
            return response()->json(['code' => 'SN202', 'message' => '数据已经存在']);
        }

        // 执行数据保存(调用service)
        $result = self::$productSubWarehouseStore->store($data);

        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功']);
        }
        return response()->json(['code' => 'SN201', 'message' => '添加失败']);

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
        $info = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        // 执行修改
        $res = self::$productSubWarehouseStore->status($request->id, $status);

        if ($res) {
            return response()->json(['code' => 'SN200', 'message' => '状态修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '状态修改失败!']);
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
        $info = self::$productSubWarehouseStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        return response()->json(['code' => 'SN200', 'message' => '查询数据成功', 'data' => $info]);

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
        $info = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$productSubWarehouseStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);


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

        // 获取指定数据
        // 判断数据是否存在
        $info = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$productSubWarehouseStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }

    /**
     * 修改数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function update(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|min:2',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount != 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 验证数据是否重复
        $updateCount = self::$productSubWarehouseStore->getOneInfoCount(['name' => $request->name]);
        if ($updateCount> 0) {
            return response()->json(['code' => 'SN201', 'message' => '数据已存在']);
        }

        // 指定添加
        $dataStatus = self::$productSubWarehouseStore->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }
}
