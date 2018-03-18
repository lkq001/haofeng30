<?php

namespace App\Store;

use App\Model\AssessContent;

class AssessContentStore
{
    // 静态方法
    private static $assessContent = null;

    public function __construct(
        AssessContent $assessContent
    )
    {
        self::$assessContent = $assessContent;
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

        return self::$assessContent->where($where)->count();
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

        return self::$assessContent->where($where)->first();
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
            self::$assessContent->$k = $v;
        }

        return self::$assessContent->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$assessContent->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $assessContent = self::$assessContent->where('assess_id', $id)->first();

        foreach ($data as $k => $v) {
            $assessContent->$k = $v;
        }
        return $assessContent->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$assessContent->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$assessContent->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$assessContent->where('id', $id)->delete();
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
        return self::$assessContent->orderBy('order_by', 'DESC')->with(['getOneArticleLists'])->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$assessContent->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$assessContent->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$assessContent->where('status', 1)->get();
    }

}