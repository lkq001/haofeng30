<?php

namespace App\Http\Controllers\Admin;

use App\Service\CouponService;
use App\Store\CouponRecordingStore;
use App\Store\CouponStore;
use App\Store\MemberCouponStore;
use App\Store\MemberStore;
use App\Tools\Common;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    // 静态方法
    private static $couponStore = null;
    private static $memberCouponStore = null;
    private static $memberStore = null;
    private static $couponRecordingStore = null;
    private static $couponService = null;

    // 防注入
    public function __construct(
        CouponStore $couponStore,
        MemberCouponStore $memberCouponStore,
        MemberStore $memberStore,
        CouponRecordingStore $couponRecordingStore,
        CouponService $couponService
    )
    {
        self::$couponStore = $couponStore;
        self::$memberCouponStore = $memberCouponStore;
        self::$memberStore = $memberStore;
        self::$couponRecordingStore = $couponRecordingStore;
        self::$couponService = $couponService;
    }

    //
    public function index(Request $request)
    {
        $lists = self::$couponStore->getAll('', config('config.page_size_l'));
        $count = self::$couponStore->count();

        return view('admin.coupon.index', [
            'count' => $count,
            'lists' => $lists
        ]);
    }

    public function add()
    {
        return view('admin.coupon.add');
    }

    /**
     * 添加
     *
     * @param Request $request
     * @return $this
     * author 李克勤
     */
    public function store(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'thumb' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'buy_total' => 'required',
            'relief_price' => 'required',
            'coupon_num' => 'required',
            'abstract' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 查询数据是否重复
        $count = self::$couponStore->getOneInfoCount(['name' => $request->name]);
        if ($count > 0) {
            return response()->json(['code' => 'SN202', 'message' => '数据已经存在']);
        }

        $data = $request->except('_token');

        // 保存数据
        $result = self::$couponStore->store($data);

        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功']);
        }
        return response()->json(['code' => 'SN201', 'message' => '添加失败']);

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
        $success = Common::thumb($request->image, 'coupon');

        if ($success) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功!', 'img' => config('config.thumb_image') . '/' . $success]);
        }
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
        $count = self::$couponStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 2) {
            $status = 1;
        } else {
            $status = 2;
        }
        // 执行修改
        $res = self::$couponStore->update($request->id, ['status' => $status]);

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
        $count = self::$couponStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$couponStore->destroy($request->id);

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

        // 判断数据是否存在
        $count = self::$couponStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$couponStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);

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
        $info = self::$couponStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        return view('admin.coupon.edit', [
            'info' => $info,
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
            'start_time' => 'required',
            'end_time' => 'required',
            'buy_total' => 'required',
            'relief_price' => 'required',
            'coupon_num' => 'required',
            'abstract' => 'required',
        ]);
        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 执行保存
        $result = self::$couponStore->update($request->id, $data);

        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '修改成功']);
        }
        return response()->json(['code' => 'SN201', 'message' => '修改失败']);

    }

    /**
     * 获取修改数据信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function issue(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'phones' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 整理手机号
        $phones = (explode(",", $request->phones));

        foreach( $phones as $k=>$v){
            if( !$v )
                unset( $phones[$k] );
        }

        if (count($phones) < 1) {
            return response()->json(['code' => 'SN202', 'message' => '请输入手机号']);
        }

        $result = self::$couponService->issue($request->id, $request->coupon_number, $phones);
        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '添加失败!']);

    }
}
