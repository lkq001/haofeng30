<?php
namespace App\Service;

use App\Store\ProductCategoryStore;
use App\Store\ProductWarehouseStore;
use Validator;

class ProductWarehouseService
{
    // 静态方法
    private static $productWarehouseStore = null;
    private static $commonService = null;
    private static $productCategoryStore = null;

    /**
     * ProductWarehouseService constructor.
     * @param ProductWarehouseStore $productWarehouseStore
     * @param CommonService $commonService
     * @param ProductCategoryStore $productCategoryStore
     */
    public function __construct(
        ProductWarehouseStore $productWarehouseStore,
        CommonService $commonService,
        ProductCategoryStore $productCategoryStore
    ){
        self::$productWarehouseStore = $productWarehouseStore;
        self::$commonService = $commonService;
        self::$productCategoryStore = $productCategoryStore;
    }

    // 查询产品栏目信息
    public function getProductCategory()
    {
        return self::$productCategoryStore->getAll();
    }

    /**
     * 验证数据是否存在
     *
     * @param $request
     * @return bool
     * author 李克勤
     */
    public function getOneStatus($request)
    {
        $where = self::$commonService->requestToArray($request);

        if (count($where) > 0) {
            $oneInfo = self::$productWarehouseStore->getOneInfoCount($where);
            if ($oneInfo) {
                return $oneInfo;
            }
            return 0;
        }
        return 0;
    }

    /**
     * 验证数据是否存在
     *
     * @param $request
     * @return bool
     * author 李克勤
     */
    public function getOneInfo($request)
    {
        $where = self::$commonService->requestToArray($request);

        if (count($where) > 0) {
            $oneInfo = self::$productWarehouseStore->getOneInfo($where);
            if ($oneInfo) {
                return $oneInfo;
            }
            return [];
        }
        return [];
    }

    /**
     * 执行添加
     *
     * @param $request
     * @return mixed
     * author 李克勤
     */
    public function store($request)
    {
        $data = self::$commonService->requestToArray($request);

        // 保存数据
        return self::$productWarehouseStore->store($data);

    }

    // 修改状态
    public function status($id, $status)
    {
        if (intval($id) > 0) {
           $changeStatus = self::$productWarehouseStore->status($id, $status);
            if ($changeStatus) {
                return $changeStatus;
            }
            return [];
        }
        return [];
    }

    // 修改数据
    public function update($id, $request)
    {
        $data = self::$commonService->requestToArray($request);

        // 修改数据
        return self::$productWarehouseStore->update($id, $data);
    }

    // 获取子栏目
    public function getChildStatus($id, $status = 0)
    {
        if (count($id) > 0) {
            $childCount = self::$productWarehouseStore->getChildCount($id, $status);
            if ($childCount) {
                return $childCount;
            }
            return 0;
        }
        return 0;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$productWarehouseStore->destroy($id);
    }

    // 批量执行删除
    public function destroys($ids)
    {
        return self::$productWarehouseStore->destroys($ids);
    }

    // 获取全部消息
    public function getAll()
    {
        return self::$productWarehouseStore->getAll();
    }

    // 获取个数
    public function count()
    {
        return self::$productWarehouseStore->count();
    }
}
