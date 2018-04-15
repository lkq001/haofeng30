<?php

namespace App\Http\Controllers\Api\V1;

use App\Service\ProductWarehouseService;
use App\Store\MemberGroupProductStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberGroupProductController extends Controller
{
    // 静态方法
    private static $memberGroupProductStore = null;

    // 防注入
    public function __construct(MemberGroupProductStore $memberGroupProductStore)
    {
        self::$memberGroupProductStore = $memberGroupProductStore;
    }

    public function getProductData(Request $request)
    {
        $where = [
            'member_group_id' => 1,
            'status' => 1
        ];

        $lists = self::$memberGroupProductStore->getAll($where);

        dd(collect($lists)->toArray());
    }
}
