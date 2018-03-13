<?php

namespace App\Http\Controllers\Admin;

use App\Store\MemberStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberConsumptionController extends Controller
{
    // 静态方法
    private static $memberStore = null;

    public function __construct(
        MemberStore $memberStore
    )
    {
        self::$memberStore = $memberStore;
    }

    //
    public function index(Request $request)
    {
        // 消费金额排行榜
        $memberLists = self::$memberStore->getAllByDesc('', config('config.page_size_l'), 'consumption_price', false);

        return view('admin.memberConsumption.index', [
            'memberLists' => $memberLists,
        ]);
    }
}
