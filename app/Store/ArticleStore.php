<?php

namespace App\Store;

use App\Model\Article;

class ArticleStore
{
    // 静态方法
    private static $article = null;

    public function __construct(
        Article $article
    ){
        self::$article = $article;
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

        return self::$article->where($where)->count();
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

        return self::$article->where($where)->first();
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
            self::$article->$k = $v;
        }
        return self::$article->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$article->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $article = self::$article->find($id);

        foreach ($data as $k => $v) {
            $article->$k = $v;
        }
        return $article->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$article->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$article->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$article->where('id', $id)->delete();
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
        return self::$article->orderBy('order_by', 'DESC')->with(['getOneArticleLists'])->paginate($pageSize);
    }

    // 数量
    public function count()
    {
        return self::$article->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$article->whereIn('id', $ids)->delete();
    }

    // 获取有效数据
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$article->where('status', 1)->get();
    }

}