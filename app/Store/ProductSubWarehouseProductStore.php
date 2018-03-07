<?php

namespace App\Store;

use App\Model\ProductSubWarehouse;
use App\Model\ProductSubWarehouseProduct;
use Illuminate\Support\Facades\DB;

class ProductSubWarehouseProductStore
{
    // 静态方法
    private static $productSubWarehouseProduct = null;

    public function __construct(
        ProductSubWarehouseProduct $productSubWarehouseProduct
    )
    {
        self::$productSubWarehouseProduct = $productSubWarehouseProduct;
    }

    /**
     * 获取一条数据(数量)
     *
     * @param $where
     * @return bool
     * author 李克勤
     */
    public function getOneInfoCount($where)
    {
        if (empty($where)) {
            return false;
        }

        return self::$productSubWarehouseProduct->where($where)->count();
    }

    /**
     * 获取指定条件所有数据
     *
     * @param string $where
     * @return mixed
     * author 李克勤
     */
    public function getAll($where = '')
    {
        if (empty($where)) {
            return self::$productSubWarehouseProduct->orderBy('order_by', 'DESC')->paginate(config('config.page_size_l'));
        }
        return self::$productSubWarehouseProduct->where($where)->orderBy('order_by', 'DESC')->paginate(config('config.page_size_l'));
    }

    /**
     * 获取所有数据,不分页
     *
     * @param string $where
     * @return mixed
     * author 李克勤
     */
    public function getAllNoPage($where = '')
    {
        if (empty($where)) {
            return self::$productSubWarehouseProduct->orderBy('order_by', 'DESC')->get();
        }
        return self::$productSubWarehouseProduct->where($where)->orderBy('order_by', 'DESC')->get();
    }


    // 获取指定条件数量
    public function count($where = '')
    {
        if (empty($where)) {
            return self::$productSubWarehouseProduct->count();
        }
        return self::$productSubWarehouseProduct->where($where)->count();
    }

    /**
     * 获取一条数据
     *
     * @param $where
     * @return bool
     * author 李克勤
     */
    public function getOneInfo($where)
    {
        if (empty($where)) {
            return false;
        }

        return self::$productSubWarehouseProduct->where($where)->first();
    }

    /**
     * 添加数据
     *
     * @param $data
     * @return bool
     * author 李克勤
     */
    public function insert($data)
    {
        self::$productSubWarehouseProduct->insert($data);

        return false;
    }

    public function status($id, $status)
    {
        $oneInfo = self::$productSubWarehouseProduct->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $productSubWarehouseProduct = self::$productSubWarehouseProduct->find($id);

        foreach ($data as $k => $v) {
            $productSubWarehouseProduct->$k = $v;
        }
        return $productSubWarehouseProduct->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productSubWarehouseProduct->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productSubWarehouseProduct->where('pid', $id)->count();
        }

        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productSubWarehouseProduct->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$productSubWarehouseProduct->whereIn('id', $ids)->delete();
    }

    // 批量删除
    public function destroysByProductWarehouseId($ids, $id)
    {
        return self::$productSubWarehouseProduct->whereIn('product_warehouse_id', $ids)->where('product_sub_id', $id)->delete();
    }


    // 批量修改状态
    public function statusAll($ids, $status)
    {
        // 查询所有数据
        $productWarehoustLists = self::$productSubWarehouseProduct->whereIn('id', $ids)->get();

        if (collect($productWarehoustLists)->count() > 0) {
            DB::beginTransaction();
            try {
                foreach ($productWarehoustLists as $v) {
                    $v->status = $status;
                    $v->save();
                }
                DB::commit();
                return true;
            } catch (\Exception $e) {

                DB::rollBack();
                return false;
            }
        } else {
            return false;
        }

        return self::$productSubWarehouseProduct->whereIn('id', $ids)->save(['status' => $status]);
    }

}