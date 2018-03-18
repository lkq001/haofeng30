<?php

namespace App\Store;

use App\Model\Reputation;

class ReputationStore
{
    // 静态方法
    private static $reputation = null;

    public function __construct(
        Reputation $reputation
    ){
        self::$reputation = $reputation;
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

        return self::$reputation->where($where)->count();
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

        return self::$reputation->where($where)->first();
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
            self::$reputation->$k = $v;
        }
        return self::$reputation->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$reputation->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $reputation = self::$reputation->find($id);

        foreach ($data as $k => $v) {
            $reputation->$k = $v;
        }
        return $reputation->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$reputation->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$reputation->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$reputation->where('id', $id)->delete();
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
        return self::$reputation->orderBy('order_by', 'DESC')->paginate($pageSize);
    }

    // 数量
    public function count($where = [])
    {
        if ($where) {
            return self::$reputation->where($where)->count();
        }
        return self::$reputation->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$reputation->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$reputation->where('status', 1)->get();
    }

}