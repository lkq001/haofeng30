<?php

namespace App\Http\Controllers\Admin;

use App\Store\CouponRecordingStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponRecordingController extends Controller
{
    // 静态方法
    private static $couponRecordingStore = null;

    // 防注入
    public function __construct(
        CouponRecordingStore $couponRecordingStore
    )
    {
        self::$couponRecordingStore = $couponRecordingStore;
    }

    //
    public function index()
    {
        $lists = self::$couponRecordingStore->getAll('', config('config.page_size_l'));

        $count = self::$couponRecordingStore->count();

        return  view('admin.couponRecording.index', [
            'lists' => $lists,
            'count' => $count
        ]);
    }
}
