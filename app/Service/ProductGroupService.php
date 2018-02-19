<?php
namespace App\Service;

use App\Store\ProductGroupStore;
use Validator;

class ProductGroupService
{
    // 静态方法
    private static $productGroupStore = null;
    private static $commonService = null;

    public function __construct(
        ProductGroupStore $productGroupStore,
        CommonService $commonService
    ){
        self::$productGroupStore = $productGroupStore;
        self::$commonService = $commonService;
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
            $oneInfo = self::$productGroupStore->getOneInfoCount($where);
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
            $oneInfo = self::$productGroupStore->getOneInfo($where);
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
        return self::$productGroupStore->store($data);

    }

    // 修改状态
    public function status($id, $status)
    {
        if (intval($id) > 0) {
           $changeStatus = self::$productGroupStore->status($id, $status);
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
        return self::$productGroupStore->update($id, $data);
    }

    // 获取子栏目
    public function getChildStatus($id, $status = 0)
    {
        if (count($id) > 0) {
            $childCount = self::$productGroupStore->getChildCount($id, $status);
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
        return self::$productGroupStore->destroy($id);
    }

    // 批量执行删除
    public function destroys($ids)
    {
        return self::$productGroupStore->destroys($ids);
    }

    // 获取全部消息
    public function getAll()
    {
        return self::$productGroupStore->getAll();
    }

    // 获取个数
    public function count()
    {
        return self::$productGroupStore->count();
    }
}
