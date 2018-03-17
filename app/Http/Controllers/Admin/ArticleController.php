<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store\ArticleCategoryStore;
use App\Store\ArticleStore;
use App\Tools\Common;
use Illuminate\Http\Request;
use Validator;

class ArticleController extends Controller
{
    // 静态方法
    private static $articleStore = null;
    private static $articleCategoryStore = null;

    // 防注入
    public function __construct(
        ArticleStore $articleStore,
        ArticleCategoryStore $articleCategoryStore
    )
    {
        self::$articleStore = $articleStore;
        self::$articleCategoryStore = $articleCategoryStore;
    }

    public function index()
    {
        $articleLists = self::$articleStore->getAll('', config('config.page_size_l'));

        return view('admin.article.index', [
            'articleLists' => $articleLists
        ]);
    }

    /**
     * 添加文章页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 李克勤
     */
    public function add()
    {
        $articleCategoryLists = self::$articleCategoryStore->getAll();

        return view('admin.article.add', [
            'articleCategoryLists' => $articleCategoryLists
        ]);
    }

    /**
     * 单图剪切上传
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function postUpload(Request $request)
    {
        $success = Common::thumb($request->image, 'article');

        if ($success) {
            return response()->json(['code' => 'SN200', 'message' => '添加成功!', 'img' => config('config.thumb_image') . '/' . $success]);
        }
        return response()->json(['code' => 'SN201', 'message' => '添加失败!']);
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
        // 验证数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'thumb' => 'required',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // 查询数据是否重复
        $count = self::$articleStore->getOneInfoCount(['name' => $request->name]);
        if ($count > 0) {
            return redirect()->back()->withErrors('文章标题重复!')->withInput();
        }

        $data = $request->except('_token');
        if ($request->editorValue) {
            $data['content'] = $request->editorValue;
            unset($data['editorValue']);
        }

        // 保存数据
        $result = self::$articleStore->store($data);

        if ($result) {
            return redirect()->back()->with('添加成功');
        };

        return redirect()->back()->withErrors('添加失败')->withInput();

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
        $count = self::$articleStore->getOneInfoCount(['id' => $request->id, 'status' => $request->status]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        if ($request->status == 2) {
            $status = 1;
        } else {
            $status = 2;
        }
        // 执行修改
        $res = self::$articleStore->update($request->id, ['status' => $status]);

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
        $count = self::$articleStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN202', 'message' => '数据不存在!']);
        }

        // 执行删除操作
        $destroyStatus = self::$articleStore->destroy($request->id);

        if ($destroyStatus) {
            return response()->json(['code' => 'SN200', 'message' => '删除数据成功!']);
        }

        return response()->json(['code' => 'SN201', 'message' => '删除数据失败!']);
    }

    /**
     * 修改排序
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function order(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'order_by' => 'required|int',
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 判断数据是否存在
        $count = self::$articleStore->getOneInfoCount(['id' => $request->id]);
        if ($count < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }
        // 执行修改数据
        $updateStatus = self::$articleStore->update($request->id, $request->except('id', '_token'));
        if ($updateStatus) {
            return response()->json(['code' => 'SN200', 'message' => '修改数据成功']);
        }

        return response()->json(['code' => 'SN201', 'message' => '修改数据失败']);

    }

    /**
     * 获取修改数据信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function edit(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        // 数据是否验证通过
        if ($validator->fails()) {
            return response()->json(['code' => 'SN202', 'message' => $validator->errors()->first()]);
        }

        // 获取指定数据
        // 判断数据是否存在
        $info = self::$articleStore->getOneInfo(['id' => $request->id]);
        if (count($info) < 1) {
            return response()->json(['code' => 'SN201', 'message' => '数据不存在!']);
        }

        $articleCategoryLists = self::$articleCategoryStore->getAll();


        return view('admin.article.edit', [
            'info' => $info,
            'articleCategoryLists' => $articleCategoryLists
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
            'thumb' => 'required',
        ]);
        // 数据是否验证通过
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->editorValue) {
            $data['content'] = $request->editorValue;
            unset($data['editorValue']);
        }

        // 执行保存
        $result = self::$articleStore->update($request->id, $data);

        if ($result) {
            return redirect()->back()->withErrors('修改成功')->withInput();
        };

        return redirect()->back()->withErrors('修改失败')->withInput();

    }
}
