<?php

namespace App\Store;

use App\Model\AssessThumb;

class AssessThumbStore
{
    // 静态方法
    private static $assessThumb = null;

    public function __construct(
        AssessThumb $assessThumb
    )
    {
        self::$assessThumb = $assessThumb;
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

        return self::$assessThumb->where($where)->count();
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

        return self::$assessThumb->where($where)->first();
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
        $arr = [];

        foreach (array_unique($data['thumb']) as $k => $v) {
            if ($v) {
                $arr[$k]['assess_id'] = $data['assess_id'];
                $arr[$k]['thumb'] = $v;
            }
        }

        return self::$assessThumb->insert($arr);
    }

    public function status($id, $status)
    {
        $oneInfo = self::$assessThumb->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $assessThumb = self::$assessThumb->find($id);

        foreach ($data as $k => $v) {
            $assessThumb->$k = $v;
        }
        return $assessThumb->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$assessThumb->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$assessThumb->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$assessThumb->where('id', $id)->delete();
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
        return self::$assessThumb->orderBy('order_by', 'DESC')->with(['getOneArticleLists'])->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$assessThumb->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$assessThumb->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$assessThumb->where('status', 1)->get();
    }


    /**
     * 获取ID字段几个
     *
     * @param string $where
     * @return mixed
     * author 李克勤
     */

    public function getAllIds($where = '')
    {
        if (empty($where)) {
            return self::$assessThumb->orderBy('order_by', 'DESC')->get(['id']);
        }
        return self::$assessThumb->where($where)->orderBy('order_by', 'DESC')->get(['id']);
    }

}