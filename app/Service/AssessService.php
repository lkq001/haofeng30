<?php

namespace App\Service;

use App\Store\AssessContentStore;
use App\Store\AssessStore;
use App\Store\AssessThumbStore;
use Illuminate\Support\Facades\DB;
use Validator;


class AssessService
{
    // 静态方法
    private static $assessStore = null;
    private static $assessContentStore = null;
    private static $assessThumbStore = null;
    private static $commonService = null;

    /**
     * AssessService constructor.
     * @param AssessStore $assessStore
     * @param CommonService $commonService
     * @param AssessThumbStore $assessThumbStore
     * @param AssessContentStore $assessContentStore
     */
    public function __construct(
        AssessStore $assessStore,
        CommonService $commonService,
        AssessThumbStore $assessThumbStore,
        AssessContentStore $assessContentStore
    )
    {
        self::$assessStore = $assessStore;
        self::$commonService = $commonService;
        self::$assessThumbStore = $assessThumbStore;
        self::$assessContentStore = $assessContentStore;
    }

    /**
     * 验证数据是否存在
     *
     * @param $request
     * @return bool
     * author 李克勤
     */
    public function getOneStatus($request)
    {
        $where = self::$commonService->requestToArray($request);

        if (count($where) > 0) {
            $oneInfo = self::$assessStore->getOneInfoCount($where);
            if ($oneInfo) {
                return $oneInfo;
            }
            return 0;
        }
        return 0;
    }

    /**
     * 验证数据是否存在
     *
     * @param $request
     * @return bool
     * author 李克勤
     */
    public function getOneInfo($request)
    {
        $where = self::$commonService->requestToArray($request);

        if (count($where) > 0) {
            $oneInfo = self::$assessStore->getOneInfo($where);
            if ($oneInfo) {
                return $oneInfo;
            }
            return [];
        }
        return [];
    }

    /**
     * 执行添加
     *
     * @param $request
     * @return mixed
     * author 李克勤
     */
    public function store($request)
    {
        $data = self::$commonService->requestToArray($request);

        // 保存到产品库中的信息
        foreach ($data as $k => $v) {

            // 内容转换
            if ($k == 'editorValue') {
                $content['content'] = $v;
                unset($data[$k]);
            }

            // 图片转换
            if ($k == 'thumb') {
                if ($k) {
                    $thumb['thumb'] = $v;
                }
                unset($data[$k]);
            }

        }

        DB::beginTransaction();
        try {
            $assess = self::$assessStore->store($data);

            // 内容赋值保存
            $content['assess_id'] = $assess->id;
            self::$assessContentStore->store($content);

            // 图片赋值保存
            $thumb['assess_id'] = $assess->id;
            self::$assessThumbStore->store($thumb);

            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollBack();
            return false;
        }

    }

    // 修改状态
    public function status($id, $status)
    {
        if (intval($id) > 0) {
            $changeStatus = self::$assessStore->status($id, $status);
            if ($changeStatus) {
                return $changeStatus;
            }
            return [];
        }
        return [];
    }

    // 修改数据
    public function update($id, $request)
    {
        $data = self::$commonService->requestToArray($request);

        $thumbOld = [];
        $thumb = [];
        $array_diff = [];
        // 保存到产品库中的信息
        foreach ($data as $k => $v) {

            // 内容转换
            if ($k == 'editorValue') {
                $content['content'] = $v;
                unset($data[$k]);
            }

            // 图片转换
            if ($k == 'thumb') {
                $thumb['thumb'] = $v;
                unset($data[$k]);
            }

            // 老图片对比
            if ($k == 'thumbOld') {
                $thumbOld = $v;
                unset($data[$k]);
            }

        }

        // 查询老图片信息
        $thumbOldLists = self::$assessThumbStore->getAllIds(['assess_id' => $id]);

        if (collect($thumbOldLists)->count() > 0) {
            // 将二维数组转换成以为数组
            $ids = array_column(collect($thumbOldLists)->toArray(), 'id');

            // 判断数组是否存在信息, 需要删除的图片ID
            $array_diff = array_diff($ids, $thumbOld);

        }

        DB::beginTransaction();
        try {
            self::$assessStore->update($id, $data);

            if ($content) {
                // 内容赋值保存
                self::$assessContentStore->update($id, $content);
            }

            if ($thumb) {
                // 图片赋值保存
                $thumb['assess_id'] = $id;
                self::$assessThumbStore->store($thumb);
            }

            if (count($array_diff) > 0) {
                self::$assessThumbStore->destroys($array_diff);
            }

            // 删除图片信息

            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollBack();
            return false;
        }

    }

    // 获取子栏目
    public function getChildStatus($id, $status = 0)
    {
        if (count($id) > 0) {
            $childCount = self::$assessStore->getChildCount($id, $status);
            if ($childCount) {
                return $childCount;
            }
            return 0;
        }
        return 0;
    }

    // 执行删除
    public function destroy($id)
    {
        return self::$assessStore->destroy($id);
    }

    // 批量执行删除
    public function destroys($ids)
    {
        return self::$assessStore->destroys($ids);
    }

    // 获取全部消息
    public function getAll()
    {
        $getAll = self::$assessStore->getAll();

        if (collect($getAll)->count() > 0) {

            foreach ($getAll as $k => $v) {

                if (collect($v->getHasOne)->count() > 0) {

                    $v->thumb = config('config.product_thumb') . '/' . $v->getHasOne->thumb;

                }

            }
        }
        return $getAll;
    }

    //  获取全部数据
    public function getAllNoPage($where = '')
    {
        $getAll = self::$assessStore->getAllNoPage($where);

        if (collect($getAll)->count() > 0) {

            foreach ($getAll as $k => $v) {

                if (collect($v->getHasOne)->count() > 0) {

                    $v->thumb = config('config.product_thumb') . '/' . $v->getHasOne->thumb;

                }

            }
        }
        return $getAll;
    }

    // 获取数量
    public function getAllNoPageCount($where = '')
    {
        return self::$assessStore->count($where);
    }

    // 获取个数
    public function count()
    {
        return self::$assessStore->count();
    }

    // 根据ids 获取数据
//    public function getAllNoPageByIds($ids)
//    {
//        $getAll = self::$assessStore->getAllNoPageByIds($ids);
//
//        if (collect($getAll)->count() > 0) {
//
//            foreach ($getAll as $k => $v) {
//
//                if (collect($v->getHasOne)->count() > 0) {
//
//                    $v->thumb = config('config.product_thumb') . '/' . $v->getHasOne->thumb;
//
//                }
//
//            }
//        }
//        return $getAll;
//    }

}
