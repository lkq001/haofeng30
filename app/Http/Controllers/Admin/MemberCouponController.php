<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store\MemberCouponStore;
use Illuminate\Http\Request;

class MemberCouponController extends Controller
{
    // 静态方法
    private static $memberCouponStore = null;

    // 防注入
    public function __construct(
        MemberCouponStore $memberCouponStore
    )
    {
        self::$memberCouponStore = $memberCouponStore;
    }

    //
    public function index(Request $request)
    {
        $lists = self::$memberCouponStore->getAll('', config('config.page_size_l'));

        $count = self::$memberCouponStore->count();

        return view('admin.memberCoupon.index', [
            'lists' => $lists,
            'count' => $count
        ]);
    }
}
