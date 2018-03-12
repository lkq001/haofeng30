<?php
namespace App\Service;

use App\Store\MemberStore;
use App\Tools\Common;
use Ramsey\Uuid\Uuid;
use Validator;
use App\Store\CategoryStore;

class MemberService
{
    // 静态方法
    private static $memberStore = null;
    private static $commonService = null;

    public function __construct(
        MemberStore $memberStore,
        CommonService $commonService
    ){
        self::$memberStore = $memberStore;
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
            $oneInfo = self::$memberStore->getOneInfoCount($where);
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
            $oneInfo = self::$memberStore->getOneInfo($where);
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
        // 数据验证
        $data = self::$commonService->requestToArray($request);

        $data['uuid'] = Uuid::uuid1()->getHex();
        if (empty($data['uuid'])) {
            return false;
        }

        // 密码加密(重置)
        $data['password'] = Common::encryptString($request['password']);
        if (!$data['password']) {
            return false;

        }
        // 释放确认密码
        unset($data['password_confirmation']);

        // 保存数据
        return self::$memberStore->store($data);

    }

    // 修改状态
    public function status($id, $status)
    {
        if (intval($id) > 0) {
           $changeStatus = self::$memberStore->status($id, $status);
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

        if (isset($data['password']) && strlen($data['password']) > 0) {
            // 密码加密(重置)
            $data['password'] = Common::encryptString($request['password']);
            if (!$data['password']) {
                return false;
            }
        } else {
            unset($data['password']);
        }

        // 释放确认密码
        unset($data['password_confirmation']);
        unset($data['uuid']);

        // 修改数据
        return self::$memberStore->update($id, $data);
    }

    // 获取子栏目
    public function getChildStatus($id, $status = 0)
    {
        if (count($id) > 0) {
            $childCount = self::$memberStore->getChildCount($id, $status);
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
        return self::$memberStore->destroy($id);
    }
}
