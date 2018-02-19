<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Category;
use Illuminate\Http\Request;
use Validator;

use App\Service\CommonService;
use App\Service\CategoryService;

class CategoryController extends AdminController
{
    // 静态变量
    private static $category = null;
    private static $commonService = null;
    private static $categoryService = null;

    // 防注入
    public function __construct(
        Category $category,
        CommonService $commonService,
        CategoryService $categoryService
    )
    {
        self::$category = $category;
        self::$commonService = $commonService;
        self::$categoryService = $categoryService;
    }

    /**
     * 后台菜单列表
     */
    public function index()
    {
        // 栏目列表
        $categoryLists = self::$category->orderBy('order_by', 'desc')->get()->groupBy('pid');

        // 栏目条数
        $count = self::$category->count();

        return view('admin.category.index', [
            'categoryLists' => $categoryLists,
            'count' => $count
        ]);
    }

    /**
     * 添加数据
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
            'route' => 'required',
            'route_alias' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$categoryService->getOneStatus(['name' => $request->name]);

        if ($infoCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '数据已经存在']);
        }

        // 指定添加
        $dataStatus = self::$categoryService->store($data);

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
        $info = self::$categoryService->getOneStatus(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 如果禁用,判断是否允许
        if ($request->status == 1) {
            // 验证该数据下面是否有有效子栏目
            $childCount = self::$categoryService->getChildStatus($request->id, 1);
            if ($childCount > 0) {
                return response()->json(['code' => 'SN201', 'message' => '栏目下面存在子栏目,禁止禁用!']);
            }
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        // 执行修改
        $res = self::$categoryService->status($request->id, $status);

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
        $info = self::$categoryService->getOneInfo(['id' => $request->id]);
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
        $info = self::$categoryService->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$categoryService->update($request->id, $request->except('id', '_token'));
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
            'name' => 'required|min:2',
            'pid' => 'required|int',
            'route' => 'required',
            'route_alias' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$categoryService->getOneStatus(['id' => $request->id]);
        if ($infoCount != 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 验证该数据下面是否有子栏目
        $childCount = self::$categoryService->getChildStatus($request->id);
        if ($childCount > 0 && $request->pid > 0) {
            return response()->json(['code' => 'SN201', 'message' => '栏目下面存在子栏目,禁止修改上级栏目']);
        }

        // 验证父类id 是够是本身id
        if ($request->id == $request->pid) {
            return response()->json(['code' => 'SN201', 'message' => '父类栏目不能为自己!']);
        }

        // 指定添加
        $dataStatus = self::$categoryService->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }

    //删除数据
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
        $info = self::$categoryService->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 验证该数据下面是否有子栏目
        $childCount = self::$categoryService->getChildStatus($request->id);
        if ($childCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '栏目下面存在子栏目,禁止删除!']);
        }

        // 执行删除操作
        $destroyStatus = self::$categoryService->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }


}
