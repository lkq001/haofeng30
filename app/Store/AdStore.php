<?php

namespace App\Store;

use App\Model\Ad;

class AdStore
{
    // 静态方法
    private static $ad = null;

    public function __construct(
        Ad $ad
    ){
        self::$ad = $ad;
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

        return self::$ad->where($where)->count();
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

        return self::$ad->where($where)->first();
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
            self::$ad->$k = $v;
        }
        return self::$ad->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$ad->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $ad = self::$ad->find($id);

        foreach ($data as $k => $v) {
            $ad->$k = $v;
        }
        return $ad->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$ad->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$ad->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$ad->where('id', $id)->delete();
    }

    /**
     *
     * 获取全部数据
     *
     * @param null $where
     * @param int $pageSize
     * @return mixed
     * author 李克勤
     */
    public function getAll($where = null, $pageSize = 10)
    {
        return self::$ad->orderBy('order_by', 'DESC')->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$ad->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$ad->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$ad->where('status', 1)->get();
    }

}