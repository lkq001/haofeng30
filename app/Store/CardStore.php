<?php

namespace App\Store;

use App\Model\Card;

class CardStore
{
    // 静态方法
    private static $card = null;

    public function __construct(
        Card $card
    ){
        self::$card = $card;
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

        return self::$card->where($where)->count();
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

        return self::$card->where($where)->first();
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
            self::$card->$k = $v;
        }
        return self::$card->save();
    }

    public function status($id, $status)
    {
        $oneInfo = self::$card->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $card = self::$card->find($id);

        foreach ($data as $k => $v) {
            $card->$k = $v;
        }
        return $card->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$card->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$card->where('pid', $id)->count();
        }


        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$card->where('id', $id)->delete();
    }


}