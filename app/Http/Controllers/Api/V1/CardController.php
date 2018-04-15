<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Store\CardStore;

class CardController extends Controller
{
    // 静态方法
    private static $cardStore = null;

    // 防注入
    public function __construct(
        CardStore $cardStore
    )
    {
        self::$cardStore = $cardStore;
    }

    // 获取宅配卡列表信息
    public function getCardData()
    {
        $lists = self::$cardStore->getCardData();

        // 判断是否有数据
        if (collect($lists)->count() > 0) {
            foreach ($lists as $k => $v) {

                $v->name = mb_substr($v->name, 0, 12);

                if ($v->getOneThumb) {
                    $v->thumb = config('config.card_thumb') .'/' .$v->getOneThumb->thumb;
                } else {
                    $v->thumb = '';
                }

            }
        }

        return $lists;
    }

}