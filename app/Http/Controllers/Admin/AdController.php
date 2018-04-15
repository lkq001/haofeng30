<?php

namespace App\Http\Controllers\Admin;

use App\Store\AdStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    // 静态方法
    private static $adStore = null;

    // 防注入
    public function __construct(AdStore $adStore)
    {
        self::$adStore = $adStore;
    }

    public function index(Request $request)
    {
        $lists = self::$adStore->getAll('', config('config.page_size_l'));
        $count = self::$adStore->count();

        return view('admin.ad.index', [
            'lists' => $lists,
            'count' => $count
        ]);
    }

    /**
     * 添加页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function add()
    {
        return view('admin.ad.add');
    }

    // 添加
    public function store(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'thumb' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN201', 'message' => $validator->errors()->first()]);
        }

        // 执行添加
        $result = self::$adStore->store($request->except('_token'));

        if ($result) {
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
        $count = self::$adStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 2) {
            $status = 1;
        } else {
            $status = 2;
        }
        // 执行修改
        $res = self::$adStore->update($request->id, ['status' => $status]);

        if ($res) {
            return response()->json(['code' => 'SN200', 'message' => '状态修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '状态修改失败!']);
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

        // 判断数据是否存在
        $info = self::$adStore->getOneInfo(['id' => $request->id]);

        return view('admin.ad.edit', [
            'info' => $info
        ]);

    }

    /**
     * 修改
     *
     * @param Request $request
     * @return $this
     * author 李克勤
     */
    public function update(Request $request)
    {
        $data = $request->except('id', '_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|min:2',
            'thumb' => 'required',
        ]);
        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 执行保存
        $result = self::$adStore->update($request->id, $data);

        if ($result) {
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

        // 判断数据是否存在
        $count = self::$adStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$adStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);

    }
}
