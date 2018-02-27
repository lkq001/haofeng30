<?php

namespace App\Service;

use App\Store\ProductCategoryStore;
use App\Store\ProductContentStore;
use App\Store\ProductThumbStore;
use App\Store\ProductWarehouseStore;
use Illuminate\Support\Facades\DB;
use Validator;


class ProductWarehouseService
{
    // 静态方法
    private static $productWarehouseStore = null;
    private static $commonService = null;
    private static $productCategoryStore = null;
    private static $productThumbStore = null;
    private static $productContentStore = null;

    /**
     * ProductWarehouseService constructor.
     * @param ProductWarehouseStore $productWarehouseStore
     * @param CommonService $commonService
     * @param ProductCategoryStore $productCategoryStore
     * @param ProductThumbStore $productThumbStore
     * @param ProductContentStore $productContentStore
     */
    public function __construct(
        ProductWarehouseStore $productWarehouseStore,
        CommonService $commonService,
        ProductCategoryStore $productCategoryStore,
        ProductThumbStore $productThumbStore,
        ProductContentStore $productContentStore
    )
    {
        self::$productWarehouseStore = $productWarehouseStore;
        self::$commonService = $commonService;
        self::$productCategoryStore = $productCategoryStore;
        self::$productThumbStore = $productThumbStore;
        self::$productContentStore = $productContentStore;
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

        // 保存到产品库中的信息
        foreach ($data as $k => $v) {

            // 内容转换
            if ($k == 'editorValue') {
                $content['content'] = $v;
                unset($data[$k]);
            }

            // 图片转换
            if ($k == 'thumb') {
                $thumb['thumb'] = $v;
                unset($data[$k]);
            }

        }

        DB::beginTransaction();
        try {
            $product = self::$productWarehouseStore->store($data);

            // 内容赋值保存
            $content['product_id'] = $product->id;
            self::$productContentStore->store($content);

            // 图片赋值保存
            $thumb['product_id'] = $product->id;
            self::$productThumbStore->store($thumb);

            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollBack();
            return false;
        }

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
