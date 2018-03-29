<?php

namespace App\Store;

use App\Model\Distribution;

class DistributionStore
{
    // 静态方法
    private static $distribution = null;

    public function __construct(
        Distribution $distribution
    ){
        self::$distribution = $distribution;
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

        return self::$distribution->where($where)->count();
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

        return self::$distribution->where($where)->first();
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
            self::$distribution->$k = $v;
        }
        return self::$distribution->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$distribution->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $distribution = self::$distribution->find($id);

        foreach ($data as $k => $v) {
            $distribution->$k = $v;
        }
        return $distribution->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$distribution->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$distribution->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$distribution->where('id', $id)->delete();
    }

    /**
     * 获取全部数据
     *
     * @return mixed
     * author 李克勤
     */
    public function getAll()
    {
        return self::$distribution->orderBy('order_by', 'DESC')->get();
    }

    // 数量
    public function count()
    {
        return self::$distribution->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$distribution->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$distribution->where('status', 1)->get();
    }

}