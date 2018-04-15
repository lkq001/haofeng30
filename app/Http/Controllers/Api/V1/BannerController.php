<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Store\BannerStore;
use Illuminate\Http\Request;

/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2018/3/29
 * Time: 17:37
 * author 李克勤
 */
class BannerController extends Controller
{
    // 静态方法
    private static $bannerStore = null;

    // 防注入
    public function __construct(BannerStore $bannerStore)
    {
        self::$bannerStore = $bannerStore;
    }

    /**
     * 获取微信小程序banner图片
     *
     * @param Request $request
     * @return mixed
     * author 李克勤
     */
    public function getBannerData(Request $request)
    {
        $lists = self::$bannerStore->getBannerData();

        return $lists;
    }
}