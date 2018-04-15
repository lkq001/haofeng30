<?php

namespace App\Http\Controllers\Api\V1;

use App\Store\AdStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    // 静态方法
    private static $adStore = null;

    // 防注入
    public function __construct(AdStore $adStore)
    {
        self::$adStore = $adStore;
    }

    /**
     * 获取宅配卡下广告位
     *
     * @param Request $request
     * @return bool
     * author 李克勤
     */
    public function getCardAd(Request $request)
    {
        $info = self::$adStore->getOneInfo(['id' => 1]);
        return $info;
    }

    /**
     * 获取产品分类下广告位
     *
     * @param Request $request
     * @return bool
     * author 李克勤
     */
    public function getAdByCategory(Request $request)
    {
        $info = self::$adStore->getOneInfo(['id' => 2]);
        return $info;
    }


}
