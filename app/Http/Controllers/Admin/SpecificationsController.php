<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store\SpecificationsCategoryStore;
use App\Store\SpecificationsStore;
use Illuminate\Http\Request;
use Validator;

class SpecificationsController extends Controller
{
    // 静态方法
    private static $specificationsStore = null;
    private static $specificationsCategoryStore = null;

    // 防注入
    public function __construct(
        SpecificationsStore $specificationsStore,
        SpecificationsCategoryStore $specificationsCategoryStore
    )
    {
        self::$specificationsStore = $specificationsStore;
        self::$specificationsCategoryStore = $specificationsCategoryStore;
    }

    // 产品规格
    public function index()
    {
        // 查询列表
        $specificationsLists = self::$specificationsStore->getAll();

        $count = self::$specificationsStore->count();

        // 调用规格参数分类
        $specificationsCategorys = self::$specificationsCategoryStore->getAll(['status' => 1]);

        return view('admin.specifications.index', [
            'specifications' => $specificationsLists,
            'specificationsCategorys' => $specificationsCategorys,
            'count' => $count ?? 0
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
        $data = $request->except('_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'pid' => 'required|int',
            'parameter' => 'required'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证通过,执行添加
        $result = self::$specificationsStore->store($data);

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
        $info = self::$specificationsStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        // 执行修改
        $res = self::$specificationsStore->update($request->id, ['status' => $status]);

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
        $info = self::$specificationsStore->getOneInfo(['id' => $request->id]);
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
        $info = self::$specificationsStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$specificationsStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);


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
            'name' => 'required|min:2'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$specificationsStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount != 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 指定添加
        $dataStatus = self::$specificationsStore->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

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
        $info = self::$specificationsStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$specificationsStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
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
        $destroyStatus = self::$specificationsStore->destroys($request->ids);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }

}
