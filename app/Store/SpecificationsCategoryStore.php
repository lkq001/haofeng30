<?php

namespace App\Store;

use App\Model\SpecificationsCategory;

class SpecificationsCategoryStore
{
    // 静态方法
    private static $specificationsCategory = null;

    public function __construct(
        SpecificationsCategory $specificationsCategory
    ){
        self::$specificationsCategory = $specificationsCategory;
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

        return self::$specificationsCategory->where($where)->count();
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
            return self::$specificationsCategory->orderBy('order_by', 'DESC')->get();
        }
        return self::$specificationsCategory->where($where)->orderBy('order_by', 'DESC')->get();
    }

    // 获取指定条件数量
    public function count($where= '')
    {
        if (empty($where)) {
            return self::$specificationsCategory->count();
        }
        return self::$specificationsCategory->where($where)->count();
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

        return self::$specificationsCategory->where($where)->first();
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
            self::$specificationsCategory->$k = $v;
        }
        return self::$specificationsCategory->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$specificationsCategory->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $specificationsCategory = self::$specificationsCategory->find($id);

        foreach ($data as $k => $v) {
            $specificationsCategory->$k = $v;
        }
        return $specificationsCategory->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$specificationsCategory->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$specificationsCategory->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$specificationsCategory->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$specificationsCategory->whereIn('id', $ids)->delete();
    }


}