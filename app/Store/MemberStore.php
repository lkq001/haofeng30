<?php

namespace App\Store;

use App\Model\Category;
use App\Model\Member;

class MemberStore
{
    // 静态方法
    private static $member = null;

    public function __construct(
        Member $member
    )
    {
        self::$member = $member;
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

        return self::$member->where($where)->count();
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

        return self::$member->where($where)->first();
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
            self::$member->$k = $v;
        }
        return self::$member->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$member->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $member = self::$member->find($id);

        foreach ($data as $k => $v) {
            $member->$k = $v;
        }
        return $member->save();
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$member->where('id', $id)->delete();
    }

    // 获取分页数据
    public function getAll($where = [], $pageSize = 10)
    {
        if (!empty($where)) {
            return self::$member->where($where)->orderBy('order_by', 'DESC')->with(['getHasOneGroup'])->paginate($pageSize);
        }
        return self::$member->orderBy('order_by', 'DESC')->with(['getHasOneGroup'])->paginate($pageSize);
    }

    // 获取数量
    public function count($where = [])
    {
        if (!empty($where)) {
            return self::$member->where($where)->count();
        }
        return self::$member->count();

    }


}