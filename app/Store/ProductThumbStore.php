<?php

namespace App\Store;

use App\Model\ProductThumb;
use App\Model\ProductWarehouse;

class ProductThumbStore
{
    // 静态方法
    private static $productThumb = null;

    public function __construct(
        ProductThumb $productThumb
    )
    {
        self::$productThumb = $productThumb;
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

        return self::$productThumb->where($where)->count();
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
            return self::$productThumb->orderBy('order_by', 'DESC')->get();
        }
        return self::$productThumb->where($where)->orderBy('order_by', 'DESC')->get();
    }

    /**
     * 获取ID字段几个
     *
     * @param string $where
     * @return mixed
     * author 李克勤
     */

    public function getAllIds($where = '')
    {
        if (empty($where)) {
            return self::$productThumb->orderBy('order_by', 'DESC')->get(['id']);
        }
        return self::$productThumb->where($where)->orderBy('order_by', 'DESC')->get(['id']);
    }

    // 获取指定条件数量
    public function count($where = '')
    {
        if (empty($where)) {
            return self::$productThumb->count();
        }
        return self::$productThumb->where($where)->count();
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

        return self::$productThumb->where($where)->first();
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
        $arr = [];

        $is_index = 1;

        foreach (array_unique($data['thumb']) as $k => $v) {
            if ($v) {
                $arr[$k]['product_id'] = $data['product_id'];
                $arr[$k]['thumb'] = $v;
                $arr[$k]['is_index'] = $is_index;
                $is_index = 2;
            }
        }

        return self::$productThumb->insert($arr);
    }

    public function status($id, $status)
    {
        $oneInfo = self::$productThumb->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $productThumb = self::$productThumb->find($id);

        foreach ($data as $k => $v) {
            $productThumb->$k = $v;
        }
        return $productThumb->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$productThumb->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$productThumb->where('pid', $id)->count();
        }

        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productThumb->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$productThumb->whereIn('id', $ids)->delete();
    }


}