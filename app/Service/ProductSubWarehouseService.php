<?php

namespace App\Service;

use App\Store\ProductCategoryStore;
use App\Store\ProductContentStore;
use App\Store\ProductSubWarehouseStore;
use App\Store\ProductThumbStore;
use App\Store\ProductWarehouseStore;
use Illuminate\Support\Facades\DB;
use Validator;


class ProductSubWarehouseService
{
    // 静态方法
    private static $productWarehouseStore = null;
    private static $commonService = null;
    private static $productSubWarehouseStore = null;

    /**
     * ProductSubWarehouseService constructor.
     * @param ProductWarehouseStore $productWarehouseStore
     * @param CommonService $commonService
     * @param ProductSubWarehouseStore $productSubWarehouseStore
     */
    public function __construct(
        ProductWarehouseStore $productWarehouseStore,
        CommonService $commonService,
        ProductSubWarehouseStore $productSubWarehouseStore
    )
    {
        self::$productWarehouseStore = $productWarehouseStore;
        self::$commonService = $commonService;
        self::$productSubWarehouseStore = $productWarehouseStore;
    }


}
