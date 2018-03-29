<?php

namespace App\Service;

use App\Store\MemberGroupProductStore;
use Validator;


class DistributionService
{
    // 静态方法
    private static $CmemberProductStore = null;
    private static $memberGroupProductStore = null;

    // 防注入
    public function __construct(
        MemberGroupProductStore $memberGroupProductStore
    )
    {
        self::$memberGroupProductStore = $memberGroupProductStore;
    }

    /**
     *获取C端会员可操作的信息
     *
     * @param array $where
     * @param int $pageSize
     * @return array|mixed
     * author 李克勤
     */
    public function getCommonProduct($where = [], $pageSize = 10)
    {
        if (!$where) {
            if (!isset($where['member_group_id'])) {
                $where['member_group_id'] = 1;
            }

            // 普通会员用户固定用户组ID 1
            $commonProductListS = self::$memberGroupProductStore->getAll($where, $pageSize);
        }
        // 普通会员用户固定用户组ID 1
        $commonProductLists = self::$memberGroupProductStore->getAll(['member_group_id' => 1], $pageSize);

        return $commonProductLists ?? [];
    }

    /**
     * 获取可以数量
     *
     * @param array $where
     * @return int
     * author 李克勤
     */
    public function count($where = [])
    {
        if (!$where) {
            if (!isset($where['member_group_id'])) {
                $where['member_group_id'] = 1;
            }

            // 普通会员用户固定用户组ID 1
            $count = self::$memberGroupProductStore->count($where);
        }
        // 普通会员用户固定用户组ID 1
        $count = self::$memberGroupProductStore->count(['member_group_id' => 1]);

        return $count ?? 0;
    }
}
