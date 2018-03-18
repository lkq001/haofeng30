<?php

namespace App\Store;

use App\Model\Assess;

class AssessStore
{
    // 静态方法
    private static $assess = null;

    public function __construct(
        Assess $assess
    )
    {
        self::$assess = $assess;
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

        return self::$assess->where($where)->count();
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

        return self::$assess->where($where)->with(['getContent', 'getThumbs'])->first();
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
            self::$assess->$k = $v;
        }

        if (self::$assess->save()) {
            return self::$assess;
        }

        return false;
    }

    public function status($id, $status)
    {
        $oneInfo = self::$assess->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $assess = self::$assess->find($id);

        foreach ($data as $k => $v) {
            $assess->$k = $v;
        }
        return $assess->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$assess->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$assess->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$assess->where('id', $id)->delete();
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
        return self::$assess->orderBy('order_by', 'DESC')->with(['getContent', 'getThumbs'])->paginate($pageSize);
    }

    // 数量
    public function count($where = '')
    {
        if ($where) {
            return self::$assess->where($where)->count();
        }
        return self::$assess->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$assess->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$assess->where('status', 1)->get();
    }

}