<?php

namespace App\Store;

use App\Model\Banner;

class BannerStore
{
    // 静态方法
    private static $banner = null;

    public function __construct(
        Banner $banner
    )
    {
        self::$banner = $banner;
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

        return self::$banner->where($where)->count();
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

        return self::$banner->where($where)->first();
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
            self::$banner->$k = $v;
        }
        return self::$banner->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$banner->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $banner = self::$banner->find($id);

        foreach ($data as $k => $v) {
            $banner->$k = $v;
        }
        return $banner->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$banner->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$banner->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$banner->where('id', $id)->delete();
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
        return self::$banner->orderBy('order_by', 'DESC')->with(['getOneBannerCategory'])->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$banner->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$banner->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$banner->where('status', 1)->get();
    }

    // 获取微信小程序幻灯图片
    public function getBannerData()
    {
        return self::$banner->where('pid', 3)->where('status', 1)->get();
    }

}