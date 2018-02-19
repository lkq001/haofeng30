<?php

namespace App\Store;

use App\Model\ProductGroup;

class ProductGroupStore
{
    // 静态方法
    private static $productGroup = null;

    public function __construct(
        ProductGroup $productGroup
    ){
        self::$productGroup = $productGroup;
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

        return self::$productGroup->where($where)->count();
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

        return self::$productGroup->where($where)->first();
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
            self::$productGroup->$k = $v;
        }
        return self::$productGroup->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$productGroup->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $productGroup = self::$productGroup->find($id);

        foreach ($data as $k => $v) {
            $productGroup->$k = $v;
        }
        return $productGroup->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productGroup->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productGroup->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productGroup->where('id', $id)->delete();
    }

    // 批量执行删除
    public function destroys($ids)
    {
        return self::$productGroup->whereIn('id', $ids)->delete();
    }

    // 获取全部列表
    public function getAll()
    {
        return self::$productGroup->orderBy('order_by', 'desc')->get();
    }

    // 获取个数

    /**
     * @return ProductGroup|null
     */
    public static function count()
    {
        return self::$productGroup->count();
    }

}