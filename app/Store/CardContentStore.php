<?php

namespace App\Store;

use App\Model\CardContent;

class CardContentStore
{
    // 静态方法
    private static $cardContent = null;

    public function __construct(
        CardContent $cardContent
    ){
        self::$cardContent = $cardContent;
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

        return self::$cardContent->where($where)->count();
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
            return self::$cardContent->orderBy('order_by', 'DESC')->get();
        }
        return self::$cardContent->where($where)->orderBy('order_by', 'DESC')->get();
    }

    // 获取指定条件数量
    public function count($where= '')
    {
        if (empty($where)) {
            return self::$cardContent->count();
        }
        return self::$cardContent->where($where)->count();
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

        return self::$cardContent->where($where)->first();
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
            self::$cardContent->$k = $v;
        }
        return self::$cardContent->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$cardContent->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $cardContent = self::$cardContent->where(['card_id' => $id])->first();

        foreach ($data as $k => $v) {
            $cardContent->$k = $v;
        }
        return $cardContent->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$cardContent->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$cardContent->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$cardContent->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$cardContent->whereIn('id', $ids)->delete();
    }


}