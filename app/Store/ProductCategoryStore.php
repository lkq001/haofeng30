<?php

namespace App\Store;

use App\Model\ProductCategory;

class ProductCategoryStore
{
    // 静态方法
    private static $productCategory = null;

    public function __construct(
        ProductCategory $productCategory
    ){
        self::$productCategory = $productCategory;
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

        return self::$productCategory->where($where)->count();
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

        return self::$productCategory->where($where)->first();
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
            self::$productCategory->$k = $v;
        }
        return self::$productCategory->save();
    }

    /**
     * 获取全部数据
     *
     * @param null $where
     * author 李克勤
     */
    public function getAll($where = null)
    {
        return self::$productCategory->orderBy('order_by', 'DESC')->get()->groupBy('pid');
    }

    public function status($id, $status)
    {
        $oneInfo = self::$productCategory->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $productCategory = self::$productCategory->find($id);

        foreach ($data as $k => $v) {
            $productCategory->$k = $v;
        }
        return $productCategory->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productCategory->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productCategory->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productCategory->where('id', $id)->delete();
    }

    // 获取子栏目
    public function getChildStatus($id, $status = 0)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productCategory->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productCategory->where('pid', $id)->count();
        }

        return $childCount;
    }

    public function count()
    {
        return self::$productCategory->count();
    }

}