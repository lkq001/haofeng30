<?php

namespace App\Store;

use App\Model\CouponRecording;

class CouponRecordingStore
{
    // 静态方法
    private static $couponRecording = null;

    public function __construct(
        CouponRecording $couponRecording
    ){
        self::$couponRecording = $couponRecording;
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

        return self::$couponRecording->where($where)->count();
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

        return self::$couponRecording->where($where)->first();
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
            self::$couponRecording->$k = $v;
        }
        return self::$couponRecording->save();
    }

    // 批量添加
    public function insertAll($data)
    {
        if (!$data) {
            return false;
        }
        return self::$couponRecording->insert($data);
    }

    public function status($id, $status)
    {
        $oneInfo = self::$couponRecording->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $couponRecording = self::$couponRecording->find($id);

        foreach ($data as $k => $v) {
            $couponRecording->$k = $v;
        }
        return $couponRecording->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$couponRecording->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$couponRecording->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$couponRecording->where('id', $id)->delete();
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
        return self::$couponRecording->orderBy('order_by', 'DESC')->with(['getOneArticleLists'])->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$couponRecording->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$couponRecording->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$couponRecording->where('status', 1)->get();
    }

}