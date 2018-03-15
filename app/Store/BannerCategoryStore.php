<?php

namespace App\Store;

use App\Model\BannerCategory;

class BannerCategoryStore
{
    // 静态方法
    private static $bannerCategory = null;

    public function __construct(
        BannerCategory $bannerCategory
    ){
        self::$bannerCategory = $bannerCategory;
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

        return self::$bannerCategory->where($where)->count();
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

        return self::$bannerCategory->where($where)->first();
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
            self::$bannerCategory->$k = $v;
        }
        return self::$bannerCategory->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$bannerCategory->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $bannerCategory = self::$bannerCategory->find($id);

        foreach ($data as $k => $v) {
            $bannerCategory->$k = $v;
        }
        return $bannerCategory->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$bannerCategory->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$bannerCategory->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$bannerCategory->where('id', $id)->delete();
    }

    /**
     * 获取全部数据
     *
     * @param null $where
     * author 李克勤
     */
    public function getAll($where = null)
    {
        return self::$bannerCategory->orderBy('order_by', 'DESC')->get();
    }

    // 数量
    public function count()
    {
        return self::$bannerCategory->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$bannerCategory->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$bannerCategory->where('status', 1)->get();
    }

}