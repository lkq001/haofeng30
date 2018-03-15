<?php

namespace App\Http\Controllers\Admin;

use App\Store\BannerCategoryStore;
use App\Store\BannerStore;
use App\Tools\Common;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    // 静态方法
    private static $bannerCategoryStore = null;
    private static $bannerStore = null;


    // 防注入
    public function __construct(BannerCategoryStore $bannerCategoryStore, BannerStore $bannerStore)
    {
        self::$bannerCategoryStore = $bannerCategoryStore;
        self::$bannerStore = $bannerStore;
    }

    //
    public function index()
    {
        $bannerCategoryLists = self::$bannerCategoryStore->getAll();

        $bannerLists = self::$bannerStore->getAll('', config('config.page_size_l'));

        if (collect($bannerLists)->count() > 0) {
            foreach ($bannerLists as $k => $v) {
                if ($v->thumb) {
                    $v->thumb = config('config.thumb_image') . $v->thumb;
                }
            }
        }

        $count = self::$bannerStore->count();

        return view('admin.banner.index', [
            'bannerCategoryLists' => $bannerCategoryLists,
            'bannerLists' => $bannerLists,
            'count' => $count
        ]);
    }

    /**
     * 添加页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function add(Request $request)
    {
        $bannerCategoryLists = self::$bannerCategoryStore->getAll();

        return view('admin.banner.add', [
            'bannerCategoryLists' => $bannerCategoryLists
        ]);
    }

    /**
     * 添加
     *
     * @param Request $request
     * @return $this
     * author 李克勤
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'order_by' => 'required|int',
            'thumb' => 'required'
        ]);
        // 数据是否验证通过
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 调用公共方法单图片上传, 返回地址链接
        $thumb = Common::upload($request, 'thumb', 'banner');

        // 图片上传成功
        if ($thumb) {
            $data['thumb'] = '/banner/' . date('Ymd', time()) . '/' . $thumb;
        } else {
            return redirect()->back()->withErrors('图片上传失败')->withInput();
        }

        // 执行保存
        $result = self::$bannerStore->store($data);

        if ($result) {
            return redirect()->back()->withErrors('添加成功')->withInput();
        };

        return redirect()->back()->withErrors('添加失败')->withInput();

    }

    /**
     * 编辑页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * author 李克勤
     */
    public function edit(Request $request)
    {
        $data = $request->except('_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
        ]);
        // 数据是否验证通过
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bannerCategoryLists = self::$bannerCategoryStore->getAll();
        $info = self::$bannerStore->getOneInfo(['id' => $request->id]);

        return view('admin.banner.edit', [
            'bannerCategoryLists' => $bannerCategoryLists,
            'info' => $info
        ]);
    }

    /**
     * 修改
     *
     * @param Request $request
     * @return $this
     * author 李克勤
     */
    public function update(Request $request)
    {
        $data = $request->except('id', '_token');

        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|min:2',
            'order_by' => 'required|int',
        ]);
        // 数据是否验证通过
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 判断是否修改了图片
        if ($request->thumb) {
            // 调用公共方法单图片上传, 返回地址链接
            $thumb = Common::upload($request, 'thumb', 'banner');

            // 图片上传成功
            if ($thumb) {
                $data['thumb'] = '/banner/' . date('Ymd', time()) . '/' . $thumb;
            } else {
                return redirect()->back()->withErrors('图片上传失败')->withInput();
            }
        }


        // 执行保存
        $result = self::$bannerStore->update($request->id, $data);

        if ($result) {
            return redirect()->back()->withErrors('修改成功')->withInput();
        };

        return redirect()->back()->withErrors('修改失败')->withInput();

    }

    /**
     * 修改状态
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function status(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'status' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否存在
        $info = self::$bannerStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 2) {
            $status = 1;
        } else {
            $status = 2;
        }
        // 执行修改
        $res = self::$bannerStore->update($request->id, ['status' => $status]);

        if ($res) {
            return response()->json(['code' => 'SN200', 'message' => '状态修改成功!']);
        };

        return response()->json(['code' => 'SN201', 'message' => '状态修改失败!']);
    }

    /**
     * 删除数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function destroy(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否存在
        $count = self::$bannerStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$bannerStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }
}
