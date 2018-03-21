<?php

namespace App\Store;

use App\Model\Teamwork;

class TeamworkStore
{
    // 静态方法
    private static $teamwork = null;

    public function __construct(
        Teamwork $teamwork
    ){
        self::$teamwork = $teamwork;
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

        return self::$teamwork->where($where)->count();
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

        return self::$teamwork->where($where)->first();
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
            self::$teamwork->$k = $v;
        }
        return self::$teamwork->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$teamwork->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $teamwork = self::$teamwork->find($id);

        foreach ($data as $k => $v) {
            $teamwork->$k = $v;
        }
        return $teamwork->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$teamwork->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$teamwork->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$teamwork->where('id', $id)->delete();
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
        return self::$teamwork->orderBy('order_by', 'DESC')->with(['getOneProduct', 'getOneProductThumb'=> function($query){
            $query->where('status', 1);
        }])->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$teamwork->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$teamwork->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$teamwork->where('status', 1)->get();
    }

}