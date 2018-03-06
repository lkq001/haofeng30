<?php

namespace App\Store;

use App\Model\CardCategory;

class CardCategoryStore
{
    // 静态方法
    private static $cardCategory = null;

    public function __construct(
        CardCategory $cardCategory
    ){
        self::$cardCategory = $cardCategory;
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

        return self::$cardCategory->where($where)->count();
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

        return self::$cardCategory->where($where)->first();
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
            self::$cardCategory->$k = $v;
        }
        return self::$cardCategory->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$cardCategory->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $cardCategory = self::$cardCategory->find($id);

        foreach ($data as $k => $v) {
            $cardCategory->$k = $v;
        }
        return $cardCategory->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$cardCategory->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$cardCategory->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$cardCategory->where('id', $id)->delete();
    }

    /**
     * 获取全部数据
     *
     * @param null $where
     * author 李克勤
     */
    public function getAll($where = null)
    {
        return self::$cardCategory->orderBy('order_by', 'DESC')->paginate(config('config.page_size_l'));
    }

    // 数量
    public function count()
    {
        return self::$cardCategory->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$cardCategory->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$cardCategory->where('status', 1)->get();
    }

}