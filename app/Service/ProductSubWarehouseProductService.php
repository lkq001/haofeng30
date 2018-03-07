<?php

namespace App\Service;

use App\Store\ProductCategoryStore;
use App\Store\ProductContentStore;
use App\Store\ProductSubWarehouseProductStore;
use App\Store\ProductSubWarehouseStore;
use App\Store\ProductThumbStore;
use App\Store\ProductWarehouseStore;
use Illuminate\Support\Facades\DB;
use Validator;


class ProductSubWarehouseProductService
{
    // 静态方法
    private static $productWarehouseStore = null;
    private static $commonService = null;
    private static $productSubWarehouseProductStore = null;

    /**
     * ProductSubWarehouseProductService constructor.
     * @param ProductWarehouseStore $productWarehouseStore
     * @param CommonService $commonService
     * @param ProductSubWarehouseProductStore $productSubWarehouseProductStore
     */
    public function __construct(
        ProductWarehouseStore $productWarehouseStore,
        CommonService $commonService,
        ProductSubWarehouseProductStore $productSubWarehouseProductStore
    )
    {
        self::$productWarehouseStore = $productWarehouseStore;
        self::$commonService = $commonService;
        self::$productSubWarehouseProductStore = $productSubWarehouseProductStore;
    }

    // 添加产品
    public function store($data = [], $id, $ids)
    {
        // 判断
        if (intval($id) < 1 || !is_array($data) || count($data) < 1) {
            return false;
        }


        // 查询产品信息是否已经存在
        $oldProductSubWarehouseLists = self::$productSubWarehouseProductStore->getAllNoPage(['product_sub_id' => $id]);

        $oldProductSubWarehouseIds = array_column(collect($oldProductSubWarehouseLists)->toArray(), 'product_warehouse_id');

        // 如果已经存在,修改
        if (collect($oldProductSubWarehouseLists)->count() > 0) {

            // 需要添加的数据
            $insertData = array();
            $insertIds = array();

            // 需要删除的数据
            $deleteData = array();
            $deleteIds = array();

            // 需要更新的数据
            $updateData = array();
            $updateIds = array();

            $insertIds = array_diff($ids, $oldProductSubWarehouseIds);

            $deleteIds = array_diff($oldProductSubWarehouseIds, $ids);

            $updateIds = array_intersect($oldProductSubWarehouseIds, $ids);

            foreach ($data as $k => $v) {

                if (in_array($v['product_warehouse_id'], $insertIds)) {
                    $insertData[] = $v;
                }

                if (in_array($v['product_warehouse_id'], $updateIds)) {

                    foreach ($oldProductSubWarehouseLists as $key => $value) {
                        if ($value->product_warehouse_id == $v['product_warehouse_id']) {
                            $v['id'] = $value->id;
                        }
                    }
                    $updateData[] = $v;
                }

            }


            DB::beginTransaction();
            try {
                if (count($insertIds) > 0) {
                    // 添加
                    self::$productSubWarehouseProductStore->insert($insertData);
                }

                if (count($deleteIds) > 0) {
                    // 删除
                    self::$productSubWarehouseProductStore->destroysByProductWarehouseId($deleteIds, $id);
                }

                if (count($updateIds) > 0) {
                    foreach ($updateData as $k => $v) {
                        $id = $v['id'];
                        if (intval($id) > 0) {
                            unset($v['id']);
                            // 修改
                            self::$productSubWarehouseProductStore->update($id, $v);
                        } else {
                            return false;
                        }

                    }
                }


                DB::commit();
                return true;
            } catch (\Exception $e) {

                DB::rollBack();
                return false;
            }

        } else {
            return self::$productSubWarehouseProductStore->insert($data);
        }


    }
}
