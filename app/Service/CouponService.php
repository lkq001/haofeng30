<?php

namespace App\Service;

use App\Store\CouponRecordingStore;
use App\Store\CouponStore;
use App\Store\MemberCouponStore;
use App\Store\MemberStore;
use Illuminate\Support\Facades\DB;
use Validator;

class CouponService
{
    // 静态方法
    private static $couponStore = null;
    private static $memberCouponStore = null;
    private static $memberStore = null;
    private static $couponRecordingStore = null;

    // 防注入
    public function __construct(
        CouponStore $couponStore,
        MemberCouponStore $memberCouponStore,
        MemberStore $memberStore,
        CouponRecordingStore $couponRecordingStore
    )
    {
        self::$couponStore = $couponStore;
        self::$memberCouponStore = $memberCouponStore;
        self::$memberStore = $memberStore;
        self::$couponRecordingStore = $couponRecordingStore;
    }

    /**
     * 优惠券分发记录
     *
     * @param $id
     * @param int $coupon_number
     * @param $phones
     * @return bool
     * author 李克勤
     */
    public function issue($id, $coupon_number = 1, $phones)
    {

        $couponRecording = [];
        $couponRecordingTrue = [];
        $membersCoupon = [];
        $couponUpdate = [];

        // 查询优惠券信息
        $couponInfo = self::$couponStore->getOneInfo(['id' => $id]);

        if (!$couponInfo) {
            return false;
        }

        DB::beginTransaction();
        try {

            if (count($phones) > 0) {
                // 声明一个参数,用于存储key值
                $j = 0;
                $m = 0;
                foreach ($phones as $k => $v) {
                    $memberInfo = self::$memberStore->getOneInfo(['phone' => $v]);

                    if (!$memberInfo) {
                        // 添加失败数据
                        $couponRecording[$k]['coupon_id'] = $id;
                        $couponRecording[$k]['coupon_number'] = $coupon_number;
                        $couponRecording[$k]['phone'] = $v;
                        $couponRecording[$k]['status'] = 2;

                    } else {
                        // 需要成功添加数据
                        $couponRecordingTrue[$k]['coupon_id'] = $id;
                        $couponRecordingTrue[$k]['coupon_number'] = $coupon_number;
                        $couponRecordingTrue[$k]['phone'] = $v;
                        $couponRecordingTrue[$k]['status'] = 1;

                        // 如果一次添加多张优惠券, 则一个会员添加多张优惠券
                        if ($coupon_number > 1) {
                            for ($i = 1; $i <= $coupon_number; $i++) {
                                $j++;
                                $membersCoupon[$j]['uuid'] = $memberInfo->uuid;
                                $membersCoupon[$j]['relief_price'] = $couponInfo->relief_price;
                                $membersCoupon[$j]['buy_total'] = $couponInfo->buy_total;
                                $membersCoupon[$j]['coupon_id'] = $couponInfo->id;
                                $membersCoupon[$j]['start_time'] = $couponInfo->start_time;
                                $membersCoupon[$j]['end_time'] = $couponInfo->end_time;
                            }
                        } else {
                            $j++;
                            $membersCoupon[$j]['uuid'] = $memberInfo->uuid;
                            $membersCoupon[$j]['relief_price'] = $couponInfo->relief_price;
                            $membersCoupon[$j]['buy_total'] = $couponInfo->buy_total;
                            $membersCoupon[$j]['coupon_id'] = $couponInfo->id;
                            $membersCoupon[$j]['start_time'] = $couponInfo->start_time;
                            $membersCoupon[$j]['end_time'] = $couponInfo->end_time;
                        }
                    }

                }
            }

            // 计算优惠券数量
            $count = count($couponRecordingTrue) * $coupon_number;
            if ($count > $couponInfo->coupon_num) {
                return false;
            }

            $couponUpdate['available_num'] = $couponInfo->available_num + $count;
            $couponUpdate['coupon_num'] = $couponInfo->coupon_num - $count;

            self::$couponStore->update($couponInfo->id, $couponUpdate);

            if (count($couponRecording) > 0) {
                // 插入错误信息
                self::$couponRecordingStore->insertAll($couponRecording);
            }
            if (count($couponRecordingTrue) > 0) {
                // 插入成功信息
                self::$couponRecordingStore->insertAll($couponRecordingTrue);
            }
            if (count($membersCoupon) > 0) {
                // 执行添加会员优惠券信息
                self::$memberCouponStore->insertAll($membersCoupon);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollBack();
            return false;
        }
    }
}
