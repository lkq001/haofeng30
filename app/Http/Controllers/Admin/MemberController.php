<?php

namespace App\Http\Controllers\Admin;

use App\Service\MemberService;
use App\Store\MemberGroupStore;
use App\Store\MemberStore;
use App\Tools\Common;
use Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    // 静态方法
    private static $memberGroupStore = null;
    private static $memberService = null;
    private static $memberStore = null;


    // 防注入
    public function __construct(MemberGroupStore $memberGroupStore, MemberService $memberService, MemberStore $memberStore)
    {
        self::$memberGroupStore = $memberGroupStore;
        self::$memberService = $memberService;
        self::$memberStore = $memberStore;
    }

    /**
     * 列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function index()
    {
        // 获取会员分组
        $memberGroupLists = self::$memberGroupStore->getAll('1');

        // 获取会员信息
        $memberLists = self::$memberStore->getAll([], config('config.page_size_l'));
//        dd(collect($memberLists)->toArray());
        // 数量
        $count = self::$memberStore->count();

        return view('admin.member.index', [
            'memberGroupLists' => $memberGroupLists,
            'memberLists' => $memberLists,
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
            'phone' => 'required|cn_phone',
            'username' => 'required|min:2',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6',
            'group_id' => 'required|int',
        ]);

        // 判断密码是否一致
        if (!Common::rePassword($request->password, $request->password_confirmation)) {
            return response()->json(['code' => 'SN202', 'message' => '密码不一致']);
        }

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 密码是否一致
        if ($request->password !== $request->password_confirmation) {
            return response()->json(['code' => 'SN202', 'message' => '密码不一致']);
        }

        // 判断用户是否存在
        $getCount = self::$memberStore->getOneInfoCount(['phone' => $request->phone]);
        if ($getCount > 0) {
            return response()->json(['code' => 'SN202', 'message' => '数据已经存在']);
        }
        // 判断用户是否存在
        $getCountByName = self::$memberStore->getOneInfoCount(['username' => $request->username]);
        if ($getCountByName > 0) {
            return response()->json(['code' => 'SN202', 'message' => '数据已经存在']);
        }


        // 获取需要提交的数据
        $data = $request->except('_token');

        $result = self::$memberService->store($data);
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
        $info = self::$memberStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 2) {
            $status = 1;
        } else {
            $status = 2;
        }
        // 执行修改
        $res = self::$memberStore->update($request->id, ['status' => $status]);

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
        $info = self::$memberStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$memberStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
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
        $info = self::$memberStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$memberStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);

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
        $info = self::$memberStore->getOneInfo(['id' => $request->id]);

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
        $data = $request->except('id', '_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'phone' => 'required|cn_phone',
            'username' => 'required|min:2',
            'group_id' => 'required|int',
            'uuid' => 'required',
        ]);

        // 判断密码是否一致
        if (strlen($request->password) > 0) {
            if (!Common::rePassword($request->password, $request->password_confirmation)) {
                return response()->json(['code' => 'SN202', 'message' => '密码不一致']);
            }
        }

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断用户是否存在
        $getCount = self::$memberStore->getOneInfoCount(['id' => $request->id, 'uuid' => $request->uuid]);
        if ($getCount < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在']);
        }

        // 判断用户是否存在
        $getAllByPhone = self::$memberStore->getAll(['phone' => $request->phone]);
        if (collect($getAllByPhone)->count() > 0) {
            foreach ($getAllByPhone as $k => $v) {
                if ($v->id != $request->id) {
                    return response()->json(['code' => 'SN202', 'message' => '手机号已经存在']);
                }
            }
        }

        // 判断用户是否存在
        $getAllByName = self::$memberStore->getAll(['username' => $request->username]);
        if (collect($getAllByName)->count() > 0 ) {
            foreach ($getAllByName as $k => $v) {
                if ($v->id != $request->id) {
                    return response()->json(['code' => 'SN202', 'message' => '用户名已经存在']);
                }
            }
        }

        // 执行数据修改
        $result = self::$memberService->update($request->id, $data);

        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }

}
