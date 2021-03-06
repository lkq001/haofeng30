<?php

namespace App\Store;

use App\Model\Specifications;

class SpecificationsStore
{
    // 静态方法
    private static $specifications = null;

    public function __construct(
        Specifications $specifications
    )
    {
        self::$specifications = $specifications;
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

        return self::$specifications->where($where)->count();
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

        return self::$specifications->where($where)->first();
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
            self::$specifications->$k = $v;
        }
        return self::$specifications->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$specifications->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $specifications = self::$specifications->find($id);

        foreach ($data as $k => $v) {
            $specifications->$k = $v;
        }
        return $specifications->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$specifications->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$specifications->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$specifications->where('id', $id)->delete();
    }

    // 批量执行删除
    public function destroys($ids)
    {
        return self::$specifications->whereIn('id', $ids)->delete();
    }

    // 获取全部列表
    public function getAll()
    {
        return self::$specifications->orderBy('order_by', 'desc')->get();
    }

    // 获取个数

    /**
     * @return |null
     */
    public static function count()
    {
        return self::$specifications->count();
    }

}