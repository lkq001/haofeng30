<?php

namespace App\Service;

use App\Store\CardCategoryStore;
use App\Store\CardContentStore;
use App\Store\CardStore;
use App\Store\CardThumbStore;
use Illuminate\Support\Facades\DB;
use Validator;

class CardService
{
    // 静态方法
    private static $cardStore = null;
    private static $cardCategoryStore = null;
    private static $commonService = null;
    private static $cardThumbStore = null;
    private static $cardContentStore = null;

    // 防注入
    public function __construct(
        CardCategoryStore $cardCategoryStore,
        CardStore $cardStore,
        CommonService $commonService,
        CardThumbStore $cardThumbStore,
        CardContentStore $cardContentStore
    )
    {
        self::$commonService = $commonService;
        self::$cardStore = $cardStore;
        self::$cardCategoryStore = $cardCategoryStore;
        self::$cardThumbStore = $cardThumbStore;
        self::$cardContentStore = $cardContentStore;
    }

    /**
     * 获取状态为真的数据
     *
     * @return mixed
     * author 李克勤
     */
    public function getAllCardgoryListExceptStatusFalse()
    {
        return self::$cardCategoryStore->getAllCardgoryListExceptStatusFalse();
    }

    // 获取一条数据
    public function getOneInfo($where = '')
    {
        if (!$where) {
            return false;
        }

        return self::$cardStore->getOneInfo($where);
    }

    /**
     * 查询一条数据(数量)
     *
     * @param $where
     * @return bool
     * author 李克勤
     */
    public function getOneCount($where = '')
    {
        if (empty($where)) {
            return false;
        }
        return self::$cardStore->getOneCount($where);
    }

    /**
     * 添加
     *
     * @param $request
     * @return bool
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
                $thumb['thumb'] = $v;
                unset($data[$k]);
            }

        }

        DB::beginTransaction();
        try {
            $card = self::$cardStore->store($data);

            // 内容赋值保存
            $content['card_id'] = $card->id;
            self::$cardContentStore->store($content);

            // 图片赋值保存
            $thumb['card_id'] = $card->id;
            self::$cardThumbStore->store($thumb);

            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollBack();
            return false;
        }

    }

    /**
     * 获取分页数据
     *
     * @param int $page
     * @return mixed
     * author 李克勤
     */
    public function getAllPaginate($page = 10)
    {
        $getAll = self::$cardStore->getAllPaginate($page);

        if (collect($getAll)->count() > 0) {

            foreach ($getAll as $k => $v) {

                if (collect($v->getOneThumb)->count() > 0) {

                    $v->thumb = config('config.card_thumb') . '/' . $v->getOneThumb->thumb;

                }

            }
        }
        return $getAll;
    }

    // 获取数量
    public function getCount()
    {
        return self::$cardStore->getCount();
    }

    // 删除
    public function destroy($id)
    {
        if (intval($id) < 1) {
            return false;
        }
        return self::$cardStore->destroy($id);
    }

    /**
     * 修改
     *
     * @param $id
     * @param $request
     * @return bool
     * author 李克勤
     */
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
        $thumbOldLists = self::$cardThumbStore->getAllIds(['card_id' => $id]);

        if (collect($thumbOldLists)->count() > 0) {
            // 将二维数组转换成以为数组
            $ids = array_column(collect($thumbOldLists)->toArray(), 'id');

            // 判断数组是否存在信息, 需要删除的图片ID
            $array_diff = array_diff($ids, $thumbOld);
        }


        DB::beginTransaction();
        try {
            self::$cardStore->update($id, $data);

            if ($content) {
                // 内容赋值保存
                self::$cardContentStore->update($id, $content);
            }

            if ($thumb) {
                // 图片赋值保存
                $thumb['card_id'] = $id;
                self::$cardThumbStore->store($thumb);
            }

            if (count($array_diff) > 0) {
                self::$cardThumbStore->destroys($array_diff);
            }

            // 删除图片信息

            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollBack();
            return false;
        }

    }

    /**
     * 批量删除
     *
     * @param $ids
     * @return mixed
     * author 李克勤
     */
    public function destroys($ids)
    {
        if (!is_array($ids) || count($ids) < 1) {
            return false;
        }
        return self::$cardStore->destroys($ids);
    }

}
