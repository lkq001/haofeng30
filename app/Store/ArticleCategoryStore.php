<?php

namespace App\Store;

use App\Model\ArticleCategory;

class ArticleCategoryStore
{
    // 静态方法
    private static $articleCategory = null;

    public function __construct(
        ArticleCategory $articleCategory
    ){
        self::$articleCategory = $articleCategory;
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

        return self::$articleCategory->where($where)->count();
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

        return self::$articleCategory->where($where)->first();
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
            self::$articleCategory->$k = $v;
        }
        return self::$articleCategory->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$articleCategory->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $articleCategory = self::$articleCategory->find($id);

        foreach ($data as $k => $v) {
            $articleCategory->$k = $v;
        }
        return $articleCategory->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$articleCategory->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$articleCategory->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$articleCategory->where('id', $id)->delete();
    }

    /**
     * 获取全部数据
     *
     * @return mixed
     * author 李克勤
     */
    public function getAll()
    {
        return self::$articleCategory->orderBy('order_by', 'DESC')->get();
    }

    // 数量
    public function count()
    {
        return self::$articleCategory->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$articleCategory->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$articleCategory->where('status', 1)->get();
    }

}