<?php

namespace App\Store;

use App\Model\CardThumb;

class CardThumbStore
{
    // 静态方法
    private static $cardThumb = null;

    public function __construct(
        CardThumb $cardThumb
    )
    {
        self::$cardThumb = $cardThumb;
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

        return self::$cardThumb->where($where)->count();
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
            return self::$cardThumb->orderBy('order_by', 'DESC')->get();
        }
        return self::$cardThumb->where($where)->orderBy('order_by', 'DESC')->get();
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
            return self::$cardThumb->orderBy('order_by', 'DESC')->get(['id']);
        }
        return self::$cardThumb->where($where)->orderBy('order_by', 'DESC')->get(['id']);
    }

    // 获取指定条件数量
    public function count($where = '')
    {
        if (empty($where)) {
            return self::$cardThumb->count();
        }
        return self::$cardThumb->where($where)->count();
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

        return self::$cardThumb->where($where)->first();
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
                $arr[$k]['card_id'] = $data['card_id'];
                $arr[$k]['thumb'] = $v;
                $arr[$k]['is_index'] = $is_index;
                $is_index = 2;
            }
        }

        return self::$cardThumb->insert($arr);
    }

    public function status($id, $status)
    {
        $oneInfo = self::$cardThumb->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $cardThumb = self::$cardThumb->find($id);

        foreach ($data as $k => $v) {
            $cardThumb->$k = $v;
        }
        return $cardThumb->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$cardThumb->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$cardThumb->where('pid', $id)->count();
        }

        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$cardThumb->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$cardThumb->whereIn('id', $ids)->delete();
    }


}