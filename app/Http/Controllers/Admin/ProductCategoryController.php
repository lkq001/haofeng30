<?php

namespace App\Http\Controllers\Admin;

use App\Service\CommonService;
use App\Store\ProductCategoryStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{

    // 静态方法
    private static $productCategoryStore = null;
    private static $commonService = null;

    /**
     * 防注入
     * ProductCategoryController constructor.
     * @param ProductCategoryStore $productCategoryStore
     * @param CommonService $commonService
     */
    public function __construct(
        ProductCategoryStore $productCategoryStore,
        CommonService $commonService
    )
    {
        self::$productCategoryStore = $productCategoryStore;
        self::$commonService = $commonService;
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
        $productCategoryLists = self::$productCategoryStore->getAll();

        $count = self::$productCategoryStore->count();

        return view('admin.productCategory.index', [
            'productCategoryLists' => $productCategoryLists ?? '',
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

        // 验证数据是否存在
        $infoCount = self::$productCategoryStore->getOneInfoCount(['name' => $request->name]);

        if ($infoCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '数据已经存在']);
        }

        // 指定添加
        $dataStatus = self::$productCategoryStore->store($data);

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目添加成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '添加失败!']);

    }

    /**
     * 状态修改
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
        $info = self::$productCategoryStore->getOneInfo(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 如果禁用,判断是否允许
        if ($request->status == 1) {
            // 验证该数据下面是否有有效子栏目
            $childCount = self::$productCategoryStore->getChildStatus($request->id, 1);
            if ($childCount > 0) {
                return response()->json(['code' => 'SN201', 'message' => '分类下面存在有效子类,禁止禁用!']);
            }
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        // 执行修改
        $res = self::$productCategoryStore->status($request->id, $status);

        if ($res) {
            return response()->json(['code' => 'SN200', 'message' => '状态修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '状态修改失败!']);
    }

    /**
     * 排序修改
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
        $info = self::$productCategoryStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$productCategoryStore->update($request->id, $request->except('id', '_token'));
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
        $info = self::$productCategoryStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 验证该数据下面是否有子栏目
        $childCount = self::$productCategoryStore->getChildStatus($request->id);
        if ($childCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '栏目下面存在子栏目,禁止删除!']);
        }

        // 执行删除操作
        $destroyStatus = self::$productCategoryStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }

    /**
     * 获取修改数据信息
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
        $info = self::$productCategoryStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        return response()->json(['code' => 'SN200', 'message' => '查询数据成功', 'data' => $info]);

    }

    /**
     * 执行修改
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
        $infoCount = self::$productCategoryStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount != 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 指定添加
        $dataStatus = self::$productCategoryStore->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }

}
