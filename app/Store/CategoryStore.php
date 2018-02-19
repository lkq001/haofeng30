<?php

namespace App\Store;

use App\Model\Category;

class CategoryStore
{
    // 静态方法
    private static $category = null;

    public function __construct(
        Category $category
    ){
        self::$category = $category;
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

        return self::$category->where($where)->count();
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

        return self::$category->where($where)->first();
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
            self::$category->$k = $v;
        }
        return self::$category->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$category->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $category = self::$category->find($id);

        foreach ($data as $k => $v) {
            $category->$k = $v;
        }
        return $category->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$category->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$category->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$category->where('id', $id)->delete();
    }


}