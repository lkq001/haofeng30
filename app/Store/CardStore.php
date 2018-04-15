<?php

namespace App\Store;

use App\Model\Card;
use Illuminate\Support\Facades\DB;

class CardStore
{
    // 静态方法
    private static $card = null;

    public function __construct(
        Card $card
    )
    {
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

        return self::$card->where($where)->with(['getToMany' => function ($query) {
            $query->where('status', 1);
        }, 'getHasOneContent'])->first();
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

        if (self::$card->save()) {
            return self::$card;
        }

        return false;
    }

    public function status($id, $status)
    {
        $oneInfo = self::$card->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    /**
     * 修改数据
     *
     * @param $id
     * @param $data
     * @return mixed
     * author 李克勤
     */
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

    // 获取一条数据(数量)
    public function getOneCount($where)
    {
        return self::$card->where($where)->count();
    }

    // 获取分页数据
    public function getAllPaginate($page, $where = '')
    {
        if (empty($where)) {
            return self::$card->orderBy('order_by', 'DESC')->with(['getOneThumb' => function ($query) {
                $query->where('is_index', 1)->where('status', 1);
            }])->paginate($page);
        }

        return self::$card->where($where)->orderBy('order_by', 'DESC')->with(['getOneThumb' => function ($query) {
            $query->where('is_index', 1)->where('status', 1);
        }])->paginate($page);
    }

    // 获取数量
    public function getCount()
    {
        return self::$card->count();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$card->whereIn('id', $ids)->delete();
    }

    // 批量修改状态
    public function statusAll($ids, $status)
    {
        // 查询所有数据
        $cardLists = self::$card->whereIn('id', $ids)->get();

        if (collect($cardLists)->count() > 0) {
            DB::beginTransaction();
            try {
                foreach ($cardLists as $v) {
                    $v->status = $status;
                    $v->save();
                }
                DB::commit();
                return true;
            } catch (\Exception $e) {

                DB::rollBack();
                return false;
            }
        } else {
            return false;
        }

        return self::$card->whereIn('id', $ids)->save(['status' => $status]);
    }

    /**
     * 获取宅配卡信息(API)
     *
     * @param string $where
     * @return mixed
     * author 李克勤
     */
    public function getCardData($where = '')
    {
        if ($where) {
            return self::$card->where($where)->where('status', 1)->with(['getOneThumb' => function ($query) {
                $query->where('is_index', 1)->where('status', 1);
            }])->orderBy('order_by', 'DESC')->get();
        }
        return self::$card->where('status', 1)->with(['getOneThumb' => function ($query) {
            $query->where('is_index', 1)->where('status', 1);
        }])->orderBy('order_by', 'DESC')->get();
    }
}