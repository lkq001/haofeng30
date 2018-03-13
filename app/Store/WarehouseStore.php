<?php

namespace App\Store;

use App\Model\Warehouse;

class WarehouseStore
{
    // 静态方法
    private static $warehouse = null;

    public function __construct(
        Warehouse $warehouse
    ){
        self::$warehouse = $warehouse;
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

        return self::$warehouse->where($where)->count();
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

        return self::$warehouse->where($where)->first();
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
            self::$warehouse->$k = $v;
        }
        return self::$warehouse->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$warehouse->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $warehouse = self::$warehouse->find($id);

        foreach ($data as $k => $v) {
            $warehouse->$k = $v;
        }
        return $warehouse->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status = '')
    {
        if ($status) {
            // 查询数据
            $childCount = self::$warehouse->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$warehouse->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$warehouse->where('id', $id)->delete();
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
            return self::$warehouse->orderBy('order_by', 'DESC')->get()->groupBy('pid');
        }
        return self::$warehouse->where($where)->orderBy('order_by', 'DESC')->get()->groupBy('pid');
    }

    // 获取所有数量
    public function getAllCount($where = '')
    {
        if (empty($where)) {
            return self::$warehouse->orderBy('order_by', 'DESC')->count();
        }
        return self::$warehouse->where($where)->orderBy('order_by', 'DESC')->count();
    }

    // 获取指定数据
    public function getCount($where = '')
    {
        if (empty($where)) {
            return false;
        }
        return self::$warehouse->where($where)->count();
    }


}