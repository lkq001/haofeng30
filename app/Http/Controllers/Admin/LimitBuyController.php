<?php

namespace App\Http\Controllers\Admin;

use App\Service\ProductWarehouseService;
use App\Store\LimitBuyStore;
use App\Store\MemberGroupProductStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LimitBuyController extends Controller
{
    // 静态方法
    private static $memberGroupProductStore = null;
    private static $productWarehouseService = null;
    private static $limitBuyStore = null;

    // 防注入
    public function __construct(
        MemberGroupProductStore $memberGroupProductStore,
        ProductWarehouseService $productWarehouseService,
        LimitBuyStore $limitBuyStore
    )
    {
        self::$memberGroupProductStore = $memberGroupProductStore;
        self::$productWarehouseService = $productWarehouseService;
        self::$limitBuyStore = $limitBuyStore;
    }

    //
    public function index()
    {
        // 查询已经启用的会员产品(仅限普通会员)
        $memberGroupProductLists = self::$memberGroupProductStore->getAllNoPage(['member_group_id' => 1]);

        $memberGroupProductIds = array_column(collect($memberGroupProductLists)->toArray(), 'product_warehouse_id');
        if (count($memberGroupProductIds) > 0) {
            // 查询产品数据信息
            $productLists = self::$productWarehouseService->getAllNoPageByIds($memberGroupProductIds);
            if (collect($productLists)->count() > 0) {
                foreach ($productLists as $k => $v) {

                    foreach ($memberGroupProductLists as $key => $value) {
                        if ($value->product_warehouse_id == $v->id) {
                            $v->price = $value->price;
                        }
                    }

                }
            }
        }

        $count = self::$limitBuyStore->count();

        // 获取列表
        $lists = self::$limitBuyStore->getAll('', config('config.page_size_l'));
//        dd(collect($lists)->toArray());
        return view('admin.limitBuy.index', [
            'productLists' => $productLists ?? [],
            'lists' => $lists,
            'count' => $count
        ]);
    }

    public function store(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'start_time' => 'required',
            'end_time' => 'required',
            'product_warehouse_id' => 'required',
            'price' => 'required',
            'old_price' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断开始时间与结束时间
        if($request->start_time >= $request->end_time) {
            return response()->json(['code' => 'SN202', 'message' => '结束时间必须大于开始时间']);
        }

        // 执行添加
        $result = self::$limitBuyStore->store($request->except('_token', 'old_price'));
        if ($result) {
            return response()->json(['code' => 'SN200', 'message' => '栏目添加成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '添加失败!']);
    }

    /**
     * 获取内容
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function show(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        $info = self::$memberGroupProductStore->getOneInfo(['member_group_id' => 1, 'product_warehouse_id' => $request->id]);

        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        return response()->json(['code' => 'SN200', 'message' => '查询数据成功', 'data' => $info]);
    }

    /**
     * 修改
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

        $info = self::$limitBuyStore->getOneInfo(['id' => $request->id]);

        // 查询单条数据价格
        $productWarehouseId = self::$memberGroupProductStore->getOneInfo(['member_group_id' => 1, 'product_warehouse_id' => $info->product_warehouse_id]);

        if ($productWarehouseId) {
            $info->old_price = $productWarehouseId->price;
        }

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
        $count = self::$limitBuyStore->getOneInfoCount(['id' => $request->id]);
        if (count($count) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$limitBuyStore->update($request->id, $request->except('id', '_token'));
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
        $count = self::$limitBuyStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$limitBuyStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
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
        $count = self::$limitBuyStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }

        // 执行修改
        $res = self::$limitBuyStore->status($request->id, $status);

        if ($res) {
            return response()->json(['code' => 'SN200', 'message' => '状态修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '状态修改失败!']);
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
            'start_time' => 'required',
            'end_time' => 'required',
            'price' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 验证数据是否存在
        $count = self::$limitBuyStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 指定添加
        $dataStatus = self::$limitBuyStore->update($request->id, $request->except('id', '_token', 'old_price'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }

}
