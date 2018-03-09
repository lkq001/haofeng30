<?php

namespace App\Service;

use App\Store\MemberGroupProductStore;
use App\Store\ProductCategoryStore;
use App\Store\ProductContentStore;
use App\Store\ProductSubWarehouseProductStore;
use App\Store\ProductSubWarehouseStore;
use App\Store\ProductThumbStore;
use App\Store\ProductWarehouseStore;
use Illuminate\Support\Facades\DB;
use Validator;


class MemberGroupProductService
{
    // 静态方法
    private static $productWarehouseStore = null;
    private static $commonService = null;
    private static $productSubWarehouseProductStore = null;
    private static $memberGroupProductStore = null;

    /**
     * ProductSubWarehouseProductService constructor.
     * @param ProductWarehouseStore $productWarehouseStore
     * @param CommonService $commonService
     * @param ProductSubWarehouseProductStore $productSubWarehouseProductStore
     */
    public function __construct(
        ProductWarehouseStore $productWarehouseStore,
        CommonService $commonService,
        ProductSubWarehouseProductStore $productSubWarehouseProductStore,
        MemberGroupProductStore $memberGroupProductStore
    )
    {
        self::$productWarehouseStore = $productWarehouseStore;
        self::$commonService = $commonService;
        self::$productSubWarehouseProductStore = $productSubWarehouseProductStore;
        self::$memberGroupProductStore = $memberGroupProductStore;
    }

    // 添加产品
    public function store($data = [], $id, $ids)
    {
        // 判断
        if (intval($id) < 1 || !is_array($data) || count($data) < 1) {
            return false;
        }

        // 查询产品信息是否已经存在
        $oldMemberGroupProductLists = self::$memberGroupProductStore->getAllNoPage(['member_group_id' => $id]);

        // 获取已经存在的ID 信息
        $oldMemberGroupProductIds = array_column(collect($oldMemberGroupProductLists)->toArray(), 'product_warehouse_id');

        // 如果已经存在,修改
        if (collect($oldMemberGroupProductLists)->count() > 0) {

            // 需要添加的数据
            $insertData = array();
            $insertIds = array();

            // 需要删除的数据
            $deleteData = array();
            $deleteIds = array();

            // 需要更新的数据
            $updateData = array();
            $updateIds = array();

            $insertIds = array_diff($ids, $oldMemberGroupProductIds);

            $deleteIds = array_diff($oldMemberGroupProductIds, $ids);

            $updateIds = array_intersect($oldMemberGroupProductIds, $ids);

            foreach ($data as $k => $v) {

                if (in_array($v['product_warehouse_id'], $insertIds)) {
                    $insertData[] = $v;
                }

                if (in_array($v['product_warehouse_id'], $updateIds)) {

                    foreach ($oldMemberGroupProductLists as $key => $value) {
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
                    self::$memberGroupProductStore->insert($insertData);
                }

                if (count($deleteIds) > 0) {
                    // 删除
                    self::$memberGroupProductStore->destroysByProductWarehouseId($deleteIds, $id);
                }

                if (count($updateIds) > 0) {
                    foreach ($updateData as $k => $v) {
                        $id = $v['id'];
                        if (intval($id) > 0) {
                            unset($v['id']);
                            // 修改
                            self::$memberGroupProductStore->update($id, $v);
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
            return self::$memberGroupProductStore->insert($data);
        }


    }
}
