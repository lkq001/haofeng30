<?php

namespace App\Http\Controllers\Admin;

use App\Store\ReputationStore;
use App\Tools\Common;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReputationController extends Controller
{
    // 静态方法
    private static $reputationStore = null;

    // 防注入
    public function __construct(
        ReputationStore $reputationStore
    )
    {
        self::$reputationStore = $reputationStore;
    }

    //
    public function index()
    {
        $lists = self::$reputationStore->getAll('', config('config.page_size_l'));

        $count = self::$reputationStore->count();

        return view('admin.reputation.index', [
            'lists' => $lists,
            'count' => $count
        ]);
    }

    /**
     * 单图剪切上传
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function postUpload(Request $request)
    {
        $success = Common::thumb($request->image, 'reputation');

        if ($success) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功!', 'img' => config('config.thumb_image') . '/' . $success]);
        }
        return response()->json(['code' => 'SN201', 'message' => '添加失败!']);
    }

    // 添加页面
    public function add(Request $request)
    {
        return view('admin.reputation.add');
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
        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'title' => 'required|min:2',
            'thumb' => 'required',
            'content' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 此添加不需要判断重复, 直接添加
        $result = self::$reputationStore->store($request->except('_token'));
        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '添加失败!']);

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
        $count = self::$reputationStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$reputationStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);

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
        $info = self::$reputationStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 2) {
            $status = 1;
        } else {
            $status = 2;
        }
        // 执行修改
        $res = self::$reputationStore->update($request->id, ['status' => $status]);

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
        $count = self::$reputationStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$reputationStore->destroy($request->id);

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
        $info = self::$reputationStore->getOneInfo(['id' => $request->id]);

        return view('admin.reputation.edit', [
            'info' => $info,
        ]);

    }

    public function update(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|min:2',
            'title' => 'required',
            'thumb' => 'required',
            'content' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $infoCount = self::$reputationStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 指定添加
        $dataStatus = self::$reputationStore->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);
    }
}
