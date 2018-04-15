<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Store\ProductCategoryStore;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    // 静态方法
    private static $productCategoryStore = null;

    // 防注入
    public function __construct(
        ProductCategoryStore $productCategoryStore
    )
    {
        self::$productCategoryStore = $productCategoryStore;
    }

    /**
     * 查询产品分类
     *
     * @param Request $request
     * @return string
     * author 李克勤
     */
    public function getCategory(Request $request)
    {
        // 获取提交数据
        $input = $request->all();

        // 组装查询条件
        $search = [
            'status' => 1,
        ];

        $lists = self::$productCategoryStore->getAllByApi($search);

        return $lists ?? '';
    }
}
