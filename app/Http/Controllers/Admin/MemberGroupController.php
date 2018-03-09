<?php

namespace App\Http\Controllers\Admin;

use App\Service\MemberGroupProductService;
use App\Service\ProductWarehouseService;
use App\Store\MemberGroupProductStore;
use App\Store\MemberGroupStore;
use App\Store\ProductSubWarehouseProductStore;
use App\Store\ProductSubWarehouseStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberGroupController extends Controller
{
    // 静态方法
    private static $productSubWarehouseStore = null;
    private static $memberGroupStore = null;
    private static $productWarehouseService = null;
    private static $memberGroupProductStore = null;
    private static $productSubWarehouseProductStore = null;
    private static $memberGroupProductService = null;

    // 防注入
    public function __construct(
        ProductSubWarehouseStore $productSubWarehouseStore,
        MemberGroupStore $memberGroupStore,
        ProductWarehouseService $productWarehouseService,
        MemberGroupProductStore $memberGroupProductStore,
        ProductSubWarehouseProductStore $productSubWarehouseProductStore,
        MemberGroupProductService $memberGroupProductService
    )
    {
        self::$productSubWarehouseStore = $productSubWarehouseStore;
        self::$memberGroupStore = $memberGroupStore;
        self::$productWarehouseService = $productWarehouseService;
        self::$memberGroupProductStore = $memberGroupProductStore;
        self::$productSubWarehouseProductStore = $productSubWarehouseProductStore;
        self::$memberGroupProductService = $memberGroupProductService;
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

    /**
     * 相关产品
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * author 李克勤
     */
    public function productLists(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 查询用户组信息
        $memberInfo = self::$memberGroupStore->getOneInfo(['id' => $request->id]);
        if ($memberInfo->status != 1 ) {
            return response()->json(['code' => 'SN201', 'message' => '改用户组信息未启用!']);
        }

        // 产品信息
        $productSubWarehouseProductLists = self::$productSubWarehouseProductStore->getAllNoPage(['product_sub_id' => $memberInfo->pid]);
        if (collect($productSubWarehouseProductLists)->count() < 1) {
            return response()->json(['code' => 'SN201', 'message' => '分库下面没有产品信息,请添加!']);
        }

        // 获取产品IDS数组
        $productIds = array_column(collect($productSubWarehouseProductLists)->toArray(), 'product_warehouse_id');

        // 查询指定IDS 的产品信息
        $productWarehouseLists = self::$productWarehouseService->getAllNoPageByIds($productIds);

        // 循环价格改成分库价格
        foreach ($productWarehouseLists as $k => $v) {

            // 循环分库产品信息
            foreach ($productSubWarehouseProductLists as $key => $value) {
                if ($v->id == $value->product_warehouse_id && $value->price > 0) {
                    $v->price = $value->price;
                }
            }

        }

        // 查询该ID下面面的已添加产品信息
        $memberGroupProductLists = self::$memberGroupProductStore->getAllNoPage(['member_group_id' => $request->id]);

        // 获取已经存在的ids
        $productSubWarehouseProductIds = array_column(collect($memberGroupProductLists)->toArray(), 'product_warehouse_id');

        // 声明一个数组,用于记录已经添加的数据
        $productHasWarehouse = array();
        $productHasWarehouseNo = array();

        if (collect($productWarehouseLists)->count() > 0) {
            foreach ($productWarehouseLists as $k => $v) {
                if (in_array($v->id, $productSubWarehouseProductIds)) {

                    $v->new_price = $v->price;
                    $v->check = 2;

                    foreach ($memberGroupProductLists as $key => $value) {
                        if ($v->id == $value->product_warehouse_id) {
                            $v->new_price = $value->price;
                            $v->check = 1;
                        }
                    }
                    $productHasWarehouse[] = $v;

                } else {
                    $productHasWarehouseNo[] = $v;
                }
            }
        }

        // 产品数量
        $count = self::$productSubWarehouseProductStore->getAllNoPageCount(['product_sub_id' => $memberInfo->pid]);

        return view('admin.memberGroup.list', [
            'productWarehouseLists' => $productWarehouseLists,
            'memberGroupProductLists' => $memberGroupProductLists,
            'productHasWarehouse' => $productHasWarehouse,
            'productHasWarehouseNo' => $productHasWarehouseNo,
            'count' => $count,
            'id' => $request->id
        ]);

    }

    /**
     * 提交产品信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function productStore(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'ids' => 'required|array',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 声明一个数组,存储需要添加的数据
        $productWarehouse = array();

        // 产品id
        $ids = $request->ids;
        // 价格数组
        $productPrice = $request->prices;

        foreach ($ids as $k => $v) {
            if (intval($v)) {
                $productWarehouse[$k]['product_warehouse_id'] = $v;
                $productWarehouse[$k]['member_group_id'] = $request->id;
                $productWarehouse[$k]['price'] = intval($productPrice[$k]);
            }
        }

        $result = self::$memberGroupProductService->store($productWarehouse, $request->id, $ids);

        if (collect($result)->count() > 0) {
            return response()->json(['code' => 'SN200', 'message' => '操作成功']);
        }
        return response()->json(['code' => 'SN201', 'message' => '操作失败']);
    }

}
