<?php

namespace App\Http\Middleware\Admin;

use App\Model\Category;
use App\Tools\Common;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @author 郭鹏超
     */
    public function handle($request, Closure $next)
    {
        // 允许的的路由
        $paths = [
            'lackList',
            'checkCreate',
            'lackDeploy',
            'getAreaByRepertoryId',
            'getRepSuburb',
            'getDriverList',
            'cityRepSuburb',
            'goodsList',
            'clientDev',
            'getMapXY',
            'addressInputTest',
            'goodsSaleUpdate',
            'goodsSaleStore',
            'getToken',
            'polygonSuburb',
            'orderPackageByCity',
            'showSuburb',
            'printCheck',
            'checkContinue',
            'polygonSuburb',
            'polygonSuburbRevise',
            'repRoute',
            'getRepertoryLists',
            'getMapXY',
            'polygonSuburb',
            'showSuburb',
            'showStore',
            'updateXY',
            'updateMapXY',
            'couponStore',
            'getRepertoryByRid',
            'doReturnGoods',
            'doBackOrders',
            'doOrderRemark',
            'storageArea',
            'deliveryReceiptPost',
            'supplierMoney',
            'replenishCollectionPost',
            'activityEdit',
            'checkoutPost',
            'moneyVerificationPost',
            'cancelVerificationPost',
            'applyInvoicePost',
            'bundleEdit',
            'couponEdit',
            'topImage',
            'reason',
            'changeBundleMarketing',
            'saleReturnPrint',
            'scrapOut',
            'feedBackPrint',
            'allotPrint',
            'purchaseInfoPrint'
        ];

//        if (empty(session('admin'))) {
//            return redirect( '/login' );
//        }

        if (!$request->isXmlHttpRequest()) {
            // 获取路径
            $path = $request->path();

            // 获取栏目信息
            $category = Category::orderBy('order_by', 'desc')->get()->groupBy('pid');

            $request->session()->put('global_nav', $category);

        }

        return $next($request);
    }
}
