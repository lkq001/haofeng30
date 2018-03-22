<?php

namespace App\Store;

use App\Model\Coupon;

class CouponStore
{
    // 静态方法
    private static $coupon = null;

    public function __construct(
        Coupon $coupon
    ){
        self::$coupon = $coupon;
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

        return self::$coupon->where($where)->count();
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

        return self::$coupon->where($where)->first();
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
            self::$coupon->$k = $v;
        }
        return self::$coupon->save();
    }


    public function status($id, $status)
    {
        $oneInfo = self::$coupon->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $coupon = self::$coupon->find($id);

        foreach ($data as $k => $v) {
            $coupon->$k = $v;
        }
        return $coupon->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$coupon->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$coupon->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$coupon->where('id', $id)->delete();
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
        return self::$coupon->orderBy('order_by', 'DESC')->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$coupon->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$coupon->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$coupon->where('status', 1)->get();
    }

}