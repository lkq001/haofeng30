<?php

namespace App\Http\Controllers\Admin;

use App\Store\WarehouseStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WarehouseController extends Controller
{

    // 静态方法
    private static $warehouseStore = null;

    public function __construct(
        WarehouseStore $warehouseStore
    )
    {
        self::$warehouseStore = $warehouseStore;
    }

    //
    public function index(Request $request)
    {
        $warehouseLists = self::$warehouseStore->getAll();

        // 数量
        $count = self::$warehouseStore->getAllCount();

        return view('admin.warehouse.index', [
            'warehouseLists' => $warehouseLists,
            'count' => $count
        ]);
    }

    /**
     * 添加仓库
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'pid' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$warehouseStore->getOneInfoCount(['name' => $request->name]);

        if ($infoCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '数据已经存在']);
        }

        // 指定添加
        $dataStatus = self::$warehouseStore->store($data);

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目添加成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '添加失败!']);
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
        $getOneCount = self::$warehouseStore->getCount(['id' => $request->id, 'status' => $request->status]);
        if ($getOneCount < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 如果禁用,判断是否允许
        if ($request->status == 1) {
            // 验证该数据下面是否有有效子栏目
            $childCount = self::$warehouseStore->getCount(['pid' => $request->id, 'status' => 1]);
            if ($childCount > 0) {
                return response()->json(['code' => 'SN201', 'message' => '栏目下面存在有效子栏目!']);
            }
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }

        // 执行修改
        $res = self::$warehouseStore->status($request->id, $status);

        if ($res) {
            return response()->json(['code' => 'SN200', 'message' => '状态修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '状态修改失败!']);
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
        $info = self::$warehouseStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$warehouseStore->update($request->id, $request->except('id', '_token'));
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
        $info = self::$warehouseStore->getOneInfoCount(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 验证该数据下面是否有子栏目
        $childCount = self::$warehouseStore->getChildCount($request->id);
        if ($childCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '栏目下面存在子栏目,禁止删除!']);
        }

        // 执行删除操作
        $destroyStatus = self::$warehouseStore->destroy($request->id);

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
        $info = self::$warehouseStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        return response()->json(['code' => 'SN200', 'message' => '查询数据成功', 'data' => $info]);

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
            'pid' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$warehouseStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount != 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 验证该数据下面是否有子栏目
        $childCount = self::$warehouseStore->getChildCount($request->id);
        if ($childCount > 0 && $request->pid > 0) {
            return response()->json(['code' => 'SN201', 'message' => '栏目下面存在子栏目,禁止修改上级栏目']);
        }

        // 验证父类id 是够是本身id
        if ($request->id == $request->pid) {
            return response()->json(['code' => 'SN201', 'message' => '父类栏目不能为自己!']);
        }

        // 指定添加
        $dataStatus = self::$warehouseStore->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }
}
