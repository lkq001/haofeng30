<?php

namespace App\Http\Controllers\Admin;

use App\Store\MemberGroupStore;
use App\Store\ProductSubWarehouseStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberGroupController extends Controller
{
    // 静态方法
    private static $productSubWarehouseStore = null;
    private static $memberGroupStore = null;

    // 防注入
    public function __construct(
        ProductSubWarehouseStore $productSubWarehouseStore,
        MemberGroupStore $memberGroupStore
    )
    {
        self::$productSubWarehouseStore = $productSubWarehouseStore;
        self::$memberGroupStore = $memberGroupStore;
    }

    //
    public function index()
    {
        $productSubWarehouseLists = self::$productSubWarehouseStore->getAllNoPage();

        // 查询列表信息
        $memberGroupLists = self::$memberGroupStore->getAll();

        // 数量
        $count = self::$memberGroupStore->count();

        return view('admin.memberGroup.index', [
            'productSubWarehouseLists' => $productSubWarehouseLists,
            'memberGroupLists' => $memberGroupLists,
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
        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'pid' => 'required|int'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 查询数据是否存在
        $getOneCount = self::$memberGroupStore->getOneInfoCount(['name' => $request->name]);
        if ($getOneCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '数据已经存在!']);
        }

        // 执行添加
        $result = self::$memberGroupStore->store($request->except('_token'));
        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功!']);
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
        $count = self::$memberGroupStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($count) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        // 执行修改
        $res = self::$memberGroupStore->status($request->id, $status);

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
        $count = self::$memberGroupStore->getOneInfoCount(['id' => $request->id]);
        if (count($count) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 执行修改数据
        $updateStatus = self::$memberGroupStore->update($request->id, $request->except('id', '_token'));
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
        $count = self::$memberGroupStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$memberGroupStore->destroy($request->id);

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
        $info = self::$memberGroupStore->getOneInfo(['id' => $request->id]);
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
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$memberGroupStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 查询修改后的名字是否重复
        $info = self::$memberGroupStore->getOneInfo(['name' => $request->name]);
        if (collect($info)->count() > 1 && $request->id != $info->id) {
            return response()->json(['code' => 'SN201', 'message' => '数据已经存在']);
        }
        // 指定添加
        $dataStatus = self::$memberGroupStore->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }


}
