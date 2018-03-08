<?php

namespace App\Http\Controllers\Admin;

use App\Service\ProductSubWarehouseProductService;
use App\Service\ProductSubWarehouseService;
use App\Service\ProductWarehouseService;
use App\Store\ProductSubWarehouseProductStore;
use App\Store\ProductSubWarehouseStore;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSubWarehouseController extends Controller
{
    // 静态方法
    private static $productWarehouseService = null;
    private static $productSubWarehouseService = null;
    private static $productSubWarehouseStore = null;
    private static $productSubWarehouseProductStore = null;
    private static $productSubWarehouseProductService = null;

    // 防注入
    public function __construct(
        ProductWarehouseService $productWarehouseService,
        ProductSubWarehouseStore $productSubWarehouseStore,
        ProductSubWarehouseService $productSubWarehouseService,
        ProductSubWarehouseProductStore $productSubWarehouseProductStore,
        ProductSubWarehouseProductService $productSubWarehouseProductService
    )
    {
        self::$productWarehouseService = $productWarehouseService;
        self::$productSubWarehouseStore = $productSubWarehouseStore;
        self::$productSubWarehouseService = $productSubWarehouseService;
        self::$productSubWarehouseProductStore = $productSubWarehouseProductStore;
        self::$productSubWarehouseProductService = $productSubWarehouseProductService;
    }

    //
    public function index(Request $request)
    {
        $productSubWarehouseLists = self::$productSubWarehouseStore->getAll();
        return view('admin.productSubWarehouse.index', [
            'productSubWarehouseLists' => $productSubWarehouseLists
        ]);
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
        // 获取可添加数据
        $data = $request->except('_token');

        // 验证规则
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否重复
        $getOne = self::$productSubWarehouseStore->getOneInfoCount(['name' => $request->name]);
        if ($getOne) {
            return response()->json(['code' => 'SN202', 'message' => '数据已经存在']);
        }

        // 执行数据保存(调用service)
        $result = self::$productSubWarehouseStore->store($data);

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
        $info = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        // 执行修改
        $res = self::$productSubWarehouseStore->status($request->id, $status);

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
        $info = self::$productSubWarehouseStore->getOneInfo(['id' => $request->id]);
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
        $info = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$productSubWarehouseStore->update($request->id, $request->except('id', '_token'));
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
        $info = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$productSubWarehouseStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
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
        $infoCount = self::$productSubWarehouseStore->getOneInfoCount(['id' => $request->id]);
        if ($infoCount != 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在']);
        }

        // 验证数据是否重复
        $updateCount = self::$productSubWarehouseStore->getOneInfoCount(['name' => $request->name]);
        if ($updateCount > 0) {
            return response()->json(['code' => 'SN201', 'message' => '数据已存在']);
        }

        // 指定添加
        $dataStatus = self::$productSubWarehouseStore->update($request->id, $request->except('id', '_token'));

        if ($dataStatus) {
            return response()->json(['code' => 'SN200', 'message' => '栏目修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '修改失败!']);

    }

    /**
     * 产品分库赋值产品信息
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function productLists(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }
        // 产品信息
        $productWarehouseLists = self::$productWarehouseService->getAllNoPage(['status' => 2]);

        // 查询该ID下面面的已添加产品信息
        $productSubWarehouseProductLists = self::$productSubWarehouseProductStore->getAllNoPage(['product_sub_id' => $request->id]);

        // 获取已经存在的ids
        $productSubWarehouseProductIds = array_column(collect($productSubWarehouseProductLists)->toArray(), 'product_warehouse_id');

        // 声明一个数组,用于记录已经添加的数据
        $productHasWarehouse = array();
        $productHasWarehouseNo = array();

        if (collect($productWarehouseLists)->count() > 0) {
            foreach ($productWarehouseLists as $k => $v) {
                if (in_array($v->id, $productSubWarehouseProductIds)) {

                    $v->new_price = $v->price;
                    $v->new_stock = '999999';
                    $v->new_sale = '0';
                    $v->check = 2;

                    foreach ($productSubWarehouseProductLists as $key => $value) {
                        if ($v->id == $value->product_warehouse_id) {
                            $v->new_price = $value->price;
                            $v->new_stock = $value->stock;
                            $v->new_sale = $value->sale_virtual;
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
        $count = self::$productWarehouseService->getAllNoPageCount(['status' => 2]);

        return view('admin.productSubWarehouse.list', [
            'productWarehouseLists' => $productWarehouseLists,
            'productSubWarehouseProductLists' => $productSubWarehouseProductLists,
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
        // 库存
        $stocks = $request->stocks;
        // 虚拟销量
        $sales = $request->sales;

        foreach ($ids as $k => $v) {
            if (intval($v)) {
                $productWarehouse[$k]['product_warehouse_id'] = $v;
                $productWarehouse[$k]['product_sub_id'] = $request->id;
                $productWarehouse[$k]['price'] = intval($productPrice[$k]);
                $productWarehouse[$k]['stock'] = intval($stocks[$k]);
                $productWarehouse[$k]['sale_virtual'] = intval($sales[$k]);
            }
        }

        $result = self::$productSubWarehouseProductService->store($productWarehouse, $request->id, $ids);

        if (collect($result)->count() > 0) {
            return response()->json(['code' => 'SN200', 'message' => '操作成功']);
        }
        return response()->json(['code' => 'SN201', 'message' => '操作失败']);
    }
}
