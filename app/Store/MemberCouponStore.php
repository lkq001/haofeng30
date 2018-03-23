<?php

namespace App\Store;

use App\Model\Coupon;
use App\Model\MemberCoupon;

class MemberCouponStore
{
    // 静态方法
    private static $memberCoupon = null;

    public function __construct(
        MemberCoupon $memberCoupon
    ){
        self::$memberCoupon = $memberCoupon;
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

        return self::$memberCoupon->where($where)->count();
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

        return self::$memberCoupon->where($where)->first();
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
            self::$memberCoupon->$k = $v;
        }
        return self::$memberCoupon->save();
    }

    /**
     * 批量添加
     *
     * @param $data
     * @return bool
     * author 李克勤
     */
    public function insertAll($data)
    {
        if (!$data) {
            return false;
        }
        return self::$memberCoupon->insert($data);
    }


    public function status($id, $status)
    {
        $oneInfo = self::$memberCoupon->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $memberCoupon = self::$memberCoupon->find($id);

        foreach ($data as $k => $v) {
            $memberCoupon->$k = $v;
        }
        return $memberCoupon->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$memberCoupon->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$memberCoupon->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$memberCoupon->where('id', $id)->delete();
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
        return self::$memberCoupon->orderBy('id', 'DESC')->with(['getOneMember'])->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$memberCoupon->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$memberCoupon->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$memberCoupon->where('status', 1)->get();
    }

}