<?php

namespace App\Http\Controllers\Admin;

use App\Store\MemberGroupStore;
use App\Tools\Common;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    // 静态方法
    private static $memberGroupStore = null;

    // 防注入
    public function __construct(MemberGroupStore $memberGroupStore)
    {
        self::$memberGroupStore = $memberGroupStore;
    }

    //
    public function index()
    {
        // 获取会员分组
        $memberGroupLists = self::$memberGroupStore->getAll('1');

        return view('admin.member.index', [
            'memberGroupLists' => $memberGroupLists
        ]);
    }

    // 添加
    public function store(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'phone' => 'required|cn_phone',
            'username' => 'required|min:2',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6',
            'group_id' => 'required|int'
        ]);

        // 判断密码是否一致
        if (!Common::rePassword($request->password, $request->password_confirmation)) {
            return response()->json(['code' => 'SN202', 'message' => '密码不一致']);
        }

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 密码加密
        $password = Common::encryptString($request->password);
        dd(strlen($password));
        // 密码是否一致

        // 获取需要提交的数据
        $data = $request->except('_token');
        dd($data);
    }
}
