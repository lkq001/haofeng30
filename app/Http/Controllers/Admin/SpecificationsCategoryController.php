<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store\SpecificationsCategoryStore;
use App\Store\SpecificationsStore;
use Illuminate\Http\Request;
use Validator;

class SpecificationsCategoryController extends Controller
{
    // 静态方法
    private static $specificationsCategoryStore = null;
    private static $specificationsStore = null;

    // 防注入
    public function __construct(
        SpecificationsCategoryStore $specificationsCategoryStore,
        SpecificationsStore $specificationsStore
    )
    {
        self::$specificationsCategoryStore = $specificationsCategoryStore;
        self::$specificationsStore = $specificationsStore;
    }

    /**
     * 产品规格列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function index()
    {
        // 查询列表
        $specificationsCategoryLists = self::$specificationsCategoryStore->getAll();

        $count = self::$specificationsCategoryStore->count();

        return view('admin.specificationsCategory.index', [
            'specificationsCategoryLists' => $specificationsCategoryLists,
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
            'name' => 'required|min:2',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证通过,执行添加
        $result = self::$specificationsCategoryStore->store($data);

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
        $info = self::$specificationsCategoryStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 1) {
            // 查询栏目下面是否存在有效子类
            $destroyInfos = self::$specificationsStore->getOneInfo(['pid' => $request->id, 'status' => 1 ]);
            if (count($destroyInfos) > 0) {
                return response()->json(['code' => 'SN202', 'message' => '分类下面存在数据,禁止禁用!']);
            }
            $status = 2;
        } else {
            $status = 1;
        }
        // 执行修改
        $res = self::$specificationsCategoryStore->update($request->id, ['status' => $status]);

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
        $info = self::$specificationsCategoryStore->getOneInfo(['id' => $request->id]);
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
        $info = self::$specificationsCategoryStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$specificationsCategoryStore->update($request->id, $request->except('id', '_token'));
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
        $infoCount = self::$specificationsCategoryStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount != 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 指定添加
        $dataStatus = self::$specificationsCategoryStore->update($request->id, $request->except('id', '_token'));

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
        $info = self::$specificationsCategoryStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 查询栏目下面是否存在有效子类
        $destroyInfos = self::$specificationsStore->getOneInfo(['pid' => $request->id]);
        if (count($destroyInfos) > 0) {
            return response()->json(['code' => 'SN202', 'message' => '分类下面存在数据,禁止删除!']);
        }

        // 执行删除操作
        $destroyStatus = self::$specificationsCategoryStore->destroy($request->id);

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
        $destroyStatus = self::$specificationsCategoryStore->destroys($request->ids);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }
}
