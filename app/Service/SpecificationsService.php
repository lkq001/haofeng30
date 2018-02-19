<?php
namespace App\Service;

use App\Store\SpecificationsStore;
use Validator;

class SpecificationsService
{
    // 静态方法
    private static $specificationsStore = null;
    private static $commonService = null;

    public function __construct(
        SpecificationsStore $specificationsStore,
        CommonService $commonService
    ){
        self::$specificationsStore = $specificationsStore;
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
            $oneInfo = self::$specificationsStore->getOneInfoCount($where);
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
            $oneInfo = self::$specificationsStore->getOneInfo($where);
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
        return self::$specificationsStore->store($data);

    }

    // 修改状态
    public function status($id, $status)
    {
        if (intval($id) > 0) {
           $changeStatus = self::$specificationsStore->status($id, $status);
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
        return self::$specificationsStore->update($id, $data);
    }

    // 获取子栏目
    public function getChildStatus($id, $status = 0)
    {
        if (count($id) > 0) {
            $childCount = self::$specificationsStore->getChildCount($id, $status);
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
        return self::$specificationsStore->destroy($id);
    }

    // 批量执行删除
    public function destroys($ids)
    {
        return self::$specificationsStore->destroys($ids);
    }

    // 获取全部消息
    public function getAll()
    {
        return self::$specificationsStore->getAll();
    }

    // 获取个数
    public function count()
    {
        return self::$specificationsStore->count();
    }
}
