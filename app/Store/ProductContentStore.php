<?php

namespace App\Store;

use App\Model\ProductContent;
use App\Model\ProductWarehouse;

class ProductContentStore
{
    // 静态方法
    private static $productContent = null;

    public function __construct(
        ProductContent $productContent
    ){
        self::$productContent = $productContent;
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

        return self::$productContent->where($where)->count();
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
            return self::$productContent->orderBy('order_by', 'DESC')->get();
        }
        return self::$productContent->where($where)->orderBy('order_by', 'DESC')->get();
    }

    // 获取指定条件数量
    public function count($where= '')
    {
        if (empty($where)) {
            return self::$productContent->count();
        }
        return self::$productContent->where($where)->count();
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

        return self::$productContent->where($where)->first();
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
            self::$productContent->$k = $v;
        }
        return self::$productContent->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$productContent->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $productContent = self::$productContent->find($id);

        foreach ($data as $k => $v) {
            $productContent->$k = $v;
        }
        return $productContent->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productContent->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productContent->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productContent->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$productContent->whereIn('id', $ids)->delete();
    }


}