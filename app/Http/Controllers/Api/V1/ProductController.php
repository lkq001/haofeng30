<?php

namespace App\Http\Controllers\Api\V1;

use App\Service\MemberGroupProductService;
use App\Service\ProductWarehouseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // 静态方法
    private static $productWarehouseService = null;
    private static $memberGroupProductService = null;

    // 防注入
    public function __construct(
        ProductWarehouseService $productWarehouseService,
        MemberGroupProductService $memberGroupProductService

    )
    {
        self::$productWarehouseService = $productWarehouseService;
        self::$memberGroupProductService = $memberGroupProductService;
    }

    // 获取通用产品C端
    public function getMemberGroupProudet()
    {
        return 123123;
    }

    /**
     * 获取普通会员组产品
     *
     * @param Request $request
     * @return array|mixed
     * author 李克勤
     */
    public function getMemberGroupProduct(Request $request)
    {
        // 获取查询数据
        $input = $request->all();

        // 组装查询数据
        $where = [
            'member_group_id' => 1
        ];

        // 获取列表数据
        $productLists = self::$memberGroupProductService->getAllByApi($where, config('config.page_size_api'));
        if (collect($productLists)->count() > 0) {
            foreach ($productLists as $k => $v) {
                if ($v->getOneProductThumb) {
                    $v->thumb = config('config.product_thumb') . '/' . $v->getOneProductThumb->thumb;
                }
                if ($v->getOneGroupProduct) {
                    $v->name = $v->getOneGroupProduct->name;
                }
            }
        }

        return $productLists ?? [];
    }
}
