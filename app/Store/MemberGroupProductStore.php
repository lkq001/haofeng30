<?php

namespace App\Store;

use App\Model\MemberGroupProduct;
use App\Model\ProductSubWarehouse;
use App\Model\ProductSubWarehouseProduct;
use Illuminate\Support\Facades\DB;

class MemberGroupProductStore
{
    // 静态方法
    private static $memberGroupProduct = null;

    public function __construct(
        MemberGroupProduct $memberGroupProduct
    )
    {
        self::$memberGroupProduct = $memberGroupProduct;
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

        return self::$memberGroupProduct->where($where)->count();
    }

    /**
     * 获取指定条件所有数据
     *
     * @param string $where
     * @param int $pageSize
     * @return mixed
     * author 李克勤
     */
    public function getAll($where = '', $pageSize = 10)
    {
        if (empty($where)) {
            return self::$memberGroupProduct->orderBy('order_by', 'DESC')->with(['getOneGroupProduct', 'getOneProductThumb' => function ($query) {
                $query->where('is_index', 1);
            }])->paginate($pageSize);
        }
        return self::$memberGroupProduct->where($where)->orderBy('order_by', 'DESC')->with(['getOneGroupProduct', 'getOneProductThumb' => function ($query) {
            $query->where('is_index', 1);
        }])->paginate($pageSize);
    }

    /**
     * 获取所有数据,不分页
     *
     * @param string $where
     * @return mixed
     * author 李克勤
     */
    public function getAllNoPage($where = '')
    {
        if (empty($where)) {
            return self::$memberGroupProduct->orderBy('order_by', 'DESC')->get();
        }
        return self::$memberGroupProduct->where($where)->orderBy('order_by', 'DESC')->get();
    }


    // 获取指定条件数量
    public function count($where = '')
    {
        if (empty($where)) {
            return self::$memberGroupProduct->count();
        }
        return self::$memberGroupProduct->where($where)->count();
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

        return self::$memberGroupProduct->where($where)->first();
    }

    /**
     * 添加数据
     *
     * @param $data
     * @return bool
     * author 李克勤
     */
    public function insert($data)
    {
        self::$memberGroupProduct->insert($data);

        return false;
    }

    public function status($id, $status)
    {
        $oneInfo = self::$memberGroupProduct->where('id', $id)->first();
        $oneInfo->status = $status;
        return $oneInfo->save();
    }

    // 修改数据
    public function update($id, $data)
    {
        // 查询数据
        $memberGroupProduct = self::$memberGroupProduct->find($id);

        foreach ($data as $k => $v) {
            $memberGroupProduct->$k = $v;
        }
        return $memberGroupProduct->save();
    }

    // 获取子栏目数据
    public function getChildCount($id, $status)
    {
        if ($status) {
            // 查询数据
            $childCount = self::$memberGroupProduct->where('pid', $id)->where('status', $status)->count();
        } else {
            // 查询数据
            $childCount = self::$memberGroupProduct->where('pid', $id)->count();
        }

        return $childCount;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$memberGroupProduct->where('id', $id)->delete();
    }

    // 批量删除
    public function destroys($ids)
    {
        return self::$memberGroupProduct->whereIn('id', $ids)->delete();
    }

    // 批量删除
    public function destroysByProductWarehouseId($ids, $id)
    {
        return self::$memberGroupProduct->whereIn('product_warehouse_id', $ids)->where('member_group_id', $id)->delete();
    }


    // 批量修改状态
    public function statusAll($ids, $status)
    {
        // 查询所有数据
        $productWarehoustLists = self::$memberGroupProduct->whereIn('id', $ids)->get();

        if (collect($productWarehoustLists)->count() > 0) {
            DB::beginTransaction();
            try {
                foreach ($productWarehoustLists as $v) {
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

        return self::$memberGroupProduct->whereIn('id', $ids)->save(['status' => $status]);
    }

    /**
     * api 接口 (每次10条)
     *
     * @param array $where
     * @param int $pageSize
     * @return mixed
     * author 李克勤
     */
    public function getAllByApi($where = [], $pageSize = 10)
    {
        if (empty($where)) {
            return self::$memberGroupProduct->orderBy('order_by', 'DESC')->with(['getOneGroupProduct', 'getOneProductThumb' => function ($query) {
                $query->where('is_index', 1);
            }])->paginate($pageSize);
        }

        return self::$memberGroupProduct->where($where)->orderBy('order_by', 'DESC')->with(['getOneGroupProduct', 'getOneProductThumb' => function ($query) {
            $query->where('is_index', 1);
        }])->paginate($pageSize);
    }
}