<?php

namespace App\Store;

use App\Model\ProductSubWarehouse;
use Illuminate\Support\Facades\DB;

class ProductSubWarehouseStore
{
    // 静态方法
    private static $productSubWarehouse = null;

    public function __construct(
        ProductSubWarehouse $productSubWarehouse
    )
    {
        self::$productSubWarehouse = $productSubWarehouse;
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

        return self::$productSubWarehouse->where($where)->count();
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
            return self::$productSubWarehouse->orderBy('order_by', 'DESC')->paginate(config('config.page_size_l'));
        }
        return self::$productSubWarehouse->where($where)->orderBy('order_by', 'DESC')->paginate(config('config.page_size_l'));
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
            return self::$productSubWarehouse->orderBy('order_by', 'DESC')->with(['getHasOne' => function ($query) {
                $query->where('is_index', 1)->where('status', 1);
            }])->get();
        }
        return self::$productSubWarehouse->where($where)->orderBy('order_by', 'DESC')->with(['getHasMany' => function ($query) {
            $query->where('is_index', 1)->where('status', 1);
        }])->get();
    }


    // 获取指定条件数量
    public function count($where = '')
    {
        if (empty($where)) {
            return self::$productSubWarehouse->count();
        }
        return self::$productSubWarehouse->where($where)->count();
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

        return self::$productSubWarehouse->where($where)->first();
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
            self::$productSubWarehouse->$k = $v;
        }

        if (self::$productSubWarehouse->save()) {
            return self::$productSubWarehouse;
        }

        return false;
    }

    public function status($id, $status)
    {
        $oneInfo = self::$productSubWarehouse->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $productSubWarehouse = self::$productSubWarehouse->find($id);

        foreach ($data as $k => $v) {
            $productSubWarehouse->$k = $v;
        }
        return $productSubWarehouse->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productSubWarehouse->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productSubWarehouse->where('pid', $id)->count();
        }

        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productSubWarehouse->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$productSubWarehouse->whereIn('id', $ids)->delete();
    }

    // 批量修改状态
    public function statusAll($ids, $status)
    {
        // 查询所有数据
        $productWarehoustLists = self::$productSubWarehouse->whereIn('id', $ids)->get();

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

        return self::$productSubWarehouse->whereIn('id', $ids)->save(['status' => $status]);
    }

}