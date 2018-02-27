<?php

namespace App\Store;

use App\Model\ProductWarehouse;

use Illuminate\Support\Facades\DB;

class ProductWarehouseStore
{
    // 静态方法
    private static $productWarehouse = null;

    public function __construct(
        ProductWarehouse $productWarehouse
    )
    {
        self::$productWarehouse = $productWarehouse;
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

        return self::$productWarehouse->where($where)->count();
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
            return self::$productWarehouse->orderBy('order_by', 'DESC')->get();
        }
        return self::$productWarehouse->where($where)->orderBy('order_by', 'DESC')->get();
    }

    // 获取指定条件数量
    public function count($where = '')
    {
        if (empty($where)) {
            return self::$productWarehouse->count();
        }
        return self::$productWarehouse->where($where)->count();
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

        return self::$productWarehouse->where($where)->first();
    }

    /**
     * 保存数据
     *
     * @param $data
     * @return bool
     * author 李克勤
     */
    public function store($data)
    {
        foreach ($data as $k => $v) {
            self::$productWarehouse->$k = $v;
        }

        if (self::$productWarehouse->save()) {
            return self::$productWarehouse;
        }

        return false;
    }

    public function status($id, $status)
    {
        $oneInfo = self::$productWarehouse->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $productWarehouse = self::$productWarehouse->find($id);

        foreach ($data as $k => $v) {
            $productWarehouse->$k = $v;
        }
        return $productWarehouse->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productWarehouse->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productWarehouse->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productWarehouse->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$productWarehouse->whereIn('id', $ids)->delete();
    }


}