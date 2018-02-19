<?php
namespace App\Tools;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * 通用工具类
 *
 * @author 郭鹏超
 */
class Common
{
    /**
     * 加密算法
     *
     * @param $user
     * @param $pwd
     * @param int $position
     * @return string
     * @author 郭鹏超
     */
    public static function cryptString($user, $pwd, $position = 3)
    {
        $subUser  = substr($user, 0, $position);
        $cryptPwd = md5($pwd);
        return md5(md5($cryptPwd . $subUser));
    }

    /**
     * 验证码生成
     *
     * @param $key
     * @author 郭鹏超
     */
    public static function captcha($key)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象,配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(10);
        $builder->setMaxFrontLines(10);
        // 可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        Session::put('code', $phrase);

        // 生成图片
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type:image/jpeg');
        $builder->output();
    }

    /**
     * 数字对应位的二进制表示
     *
     * @param array $data
     * @return string
     * @author 郭鹏超
     */
    public static function encodeBin(Array $data)
    {
        sort($data);
        // 获取最大值
        $max = $data[count($data)-1];

        // 键值互换
        $data = array_flip($data);

        $resStr = '';
        for ($i = 1; $i <= $max; $i++) {
            $resStr .= (isset($data[$i]) ? 1 : 0);
        }

        return $resStr;
    }

    /**
     * 二进制对应位的数字表示
     *
     * @param $binString
     * @return string
     * @author 郭鹏超
     */
    public static function decodeBin($binString)
    {
        // 获取最大值
        $max = strlen($binString);

        $data = [];
        for ($i = 1; $i <= $max; $i++) {
            if ($binString[$i-1] == 1) {
                $data[] = $i;
            }
        }

        return $data;
    }

    /**
     * 找家谱树
     *
     * @param $array
     * @param int $id
     * @return array
     * @author 郭鹏超
     */
    public static function getTree($array, $id = 0) {
        $tree = [];

        while ($id > 0) {
            foreach ($array as $v) {
                if ($v->id == $id) {
                    $tree[] = $v;
                    $id = $v->father_id;
                    break;
                }
            }
        }

        return array_reverse($tree);
    }

    /**
     * 判断并返回当前页码
     *
     * @param $nowPage
     * @param $count
     * @return array|bool
     * @author 郭鹏超
     */
    public static function getNowPage($nowPage, $count)
    {
        if (empty($count)) return false;
        $totalPage = ceil($count / config('config.page_num'));
        if ($nowPage < 1) $nowPage = 1;
        if ($nowPage > $totalPage) $nowPage = $totalPage;
        return ['nowPage' => (int)$nowPage, 'totalPage' => (int)$totalPage];
    }

    /**
     * 获取子孙树
     *
     * @param $arr
     * @param int $id
     * @param int $lev
     * @return array
     * @author 郭鹏超
     */
    public static function getCatTree($arr, $id = 0, $lev = 1)
    {
        // 获取子孙树
        if (empty($arr)) {
            return false;
        }

        $tree = [];

        foreach ($arr as $v) {
            if ($v->father_id == $id) {
                $v->lev = $lev;
                $tree[] = $v;
                $tree = array_merge($tree, self::getCatTree($arr, $v->id, $lev+1));
            }
        }

        return $tree;
    }

    /**
     * 数组转对象
     *
     * @param $e
     * @return object|void
     * @author 郭鹏超
     */
    public static function arrayToObject($e)
    {
        if (gettype($e) != 'array') {
            return false;
        }
        foreach ($e as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object')
                $e[$k] = (object)self::arrayToObject($v);
        }
        return (object)$e;
    }

    /**
     * CURL方法
     *
     * @param $url
     * @param bool $params
     * @param int $isPost
     * @param int $https
     * @return bool|mixed
     * @author 郭鹏超
     */
    public static function curl($url, $params = false, $isPost = 1, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }

        $url = env('DOMAIN_SERVERS') . $url;
        $data = ['param' => json_encode($params)];

        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($data)) {
                    $data = http_build_query($data);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $data);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);

        // 判断curl是否成功
        if (empty($response)) {
            //dd('12123');
            return false;
        }

        // 解析CURL返回值
        $curl = json_decode($response, true);

        // 判断CURL返回值是否成功
        if (empty($curl)) {
            $debug = env('DEV');
            if ($debug) {
                return $response;
            }
            return false;
        } else {
            return $curl;
        }
    }

    /**
     * 获取分页数据url
     *
     * @param $page
     * @param $url
     * @param array $param
     * @return bool|string
     * @author 郭鹏超
     */
    public static function getPageUrl($page, $url, $param = [])
    {
        // 判断条件是否为空
        if (empty($page) || empty($page['nowPage']) || empty($page['totalPage'])) {
            return false;
        }

        // 返回分页url
        return CustomPage::getSelfPageView($page['nowPage'], $page['totalPage'], url($url), $param);
    }

    /**
     * 请求curl后,返回结果
     *
     * @param $curl
     * @param $url
     * @param bool $isAjax
     * @return \Illuminate\Http\RedirectResponse
     * @author 郭鹏超
     */
    public static function returnCurlResult($curl, $url, $isAjax = false)
    {
        // 判断curl请求的数据
        if (!empty($curl)) {
            // 返回信息
            $result = $curl['ResultData'];
            if ($curl['ServerNo'] == 'SN200') {
                if ($isAjax) {
                    return response()->json(['ServerNo' => 200, 'ResultData' => $result]);
                } else {
                    return redirect($url)->with(['ServerNo' => 200, 'Message' => $result]);
                }
            }
            if ($isAjax) {
                return response()->json(['ServerNo' => 500, 'ResultData' => $result]);
            } else {
                return back()->with(['ServerNo' => 500, 'Message' => $result]);
            }
        }
        if ($isAjax) {
            return response()->json(['ServerNo' => 500, 'ResultData' => '请求失败,请重试!']);
        } else {
            return back()->with(['ServerNo' => 500, 'Message' => '请求失败,请重试!']);
        }
    }

    /**
     * 检查商品关联的信息是否正确
     *
     * @param $goodsGuid
     * @param $goodsInfo
     * @return array
     * @author 郭鹏超
     */
    public static function checkGoodsData($goodsGuid, $goodsInfo)
    {
        // 判断是否为空
        if (empty($goodsGuid) || empty($goodsInfo) || in_array('', $goodsInfo)) {
            return ['ServerNo' => 400, 'Message' => '没有可选的商品或必要的条件未填写'];
        }

        // 判断传过来产品guid数组长度是否与组装后产品数组长度一致
        if (count($goodsGuid) != count($goodsInfo)) {
            return ['ServerNo' => 400, 'Message' => '没有可选的商品或必要的条件未填写'];
        }

        // 判断商品是否重复
        if (count($goodsInfo) != count(array_unique(array_pluck($goodsInfo, 'goods_guid')))) {
            return ['ServerNo' => 400, 'Message' => '单据中存在重复的商品'];
        }

        return ['ServerNo' => 200, 'Message' => '数据正确'];
    }

    /**
     * 检查临采商品关联的信息是否正确
     *
     * @param $goodsGuid
     * @param $goodsInfo
     * @return array
     * @author 郭鹏超
     */
    public static function checkInterimGoodsData($goodsGuid, $goodsInfo)
    {
        // 判断是否为空
        if (empty($goodsGuid) || empty($goodsInfo) || in_array('', $goodsInfo)) {
            return ['ServerNo' => 400, 'Message' => '没有可选的商品或必要的条件未填写'];
        }

        // 判断传过来产品guid数组长度是否与组装后产品数组长度一致
        if (count($goodsGuid) != count($goodsInfo)) {
            return ['ServerNo' => 400, 'Message' => '没有可选的商品或必要的条件未填写'];
        }

        return ['ServerNo' => 200, 'Message' => '数据正确'];
    }

    /**
     * 得到有的搜索条件
     *
     * @param $data
     * @param $must
     * @return array
     * @author 郭鹏超
     */
    public static function getSearchData($data, $must)
    {
        // 获取当前分页
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        // 判断有没有偏移量,不存在设置默认值
        if (empty($data['offset'])) {
            $data['offset'] = env('PAGE_NUM');
        }
        // 参数
        $temp = [
            'param'  => [
                'nowPage' => $nowPage,
                'offset'  => $data['offset'],
                'guid'    => session('admin')->guid   // 获取用户的guid
            ],
            'search' => [
                'nowPage' => $nowPage,
                'offset'  => $data['offset'],
            ]
        ];
        // 判断条件是否为空
        if (empty($data) || empty($must)) {
            return $temp;
        }
        // 追加有的值
        foreach ($must as $v) {
            if (!empty($data[$v]) || isset($data[$v]) && $data[$v] === '0') {
                $temp['param'][$v]  = trim($data[$v]);
                $temp['search'][$v] = trim($data[$v]);
            }
        }

        return $temp;
    }

    /**
     * 手动验证规则验证
     *
     * @param $data $array 需要验证的数据
     * @param $rule $array 需要验证的规则
     * @return array
     * @author 郭鹏超
     */
    public static function validatorMake(Array $data, Array $rule)
    {
        // 检查是否为空
        if (empty($rule)) {
            return ['ServerNo' => 400, 'ResultData' => '验证规则未传入'];
        }

        // 检查校验规则
        $validator = Validator::make($data, $rule);

        // 检查验证规则是否合格
        if ($validator->fails()) {
            return ['ServerNo' => 400, 'ResultData' => $validator->errors()->all()[0]];
        }

        // 验证成功
        return ['ServerNo' => 200, 'ResultData' => '验证成功'];
    }

    /**
     * 返回分页保持数据
     *
     * @param $curl
     * @param $urlInfo
     * @param $url
     * @return \Illuminate\Http\RedirectResponse
     * @author 李克勤
     */
    public static function returnCurlUrl($curl, $urlInfo, $url)
    {
        if (!empty($curl)) {
            if ($curl['ServerNo'] == 'SN200') {
                return redirect('/'.$url.'?'.$urlInfo)->with( ['ServerNo' => 200, 'Message' => '修改成功']);
            } else {
                return back()->with( ['ServerNo' => 400, 'Message' => $curl['ResultData'] ?? '操作失败']);
            }
        }
        return back()->with(['ServerNo' => 500, 'Message' => '请求失败']);
    }

    /**
     * Unicore转中文
     *
     * @param $name
     * @return string
     * @author   cxs
     * @date    20170821
     */
    public static function unicodeDecode($name)
    {

        $json = '{"str":"'.$name.'"}';
        $arr = json_decode($json,true);
        if(empty($arr)) {
            return '';
        }
        return $arr['str'];
    }

    /**
     * 将集合中得某个字段按照拼音排序
     * @param $handle
     * @param $target
     * @param string $oder
     * @return array
     *
     */
    public static function sortByPinyin($handle, $target, $oder = 'asc')
    {
        if (!is_array($handle)) {
            return false;
        }
        $tmp = [];
        $pinyin = app('pinyin');
        switch (gettype(array_values($handle)[0])) {
            case 'object':
                foreach ($handle as $key => $value) {
                    $tmp[$key] = implode('', $pinyin->convert($value->$target));
                }
                break;
            case 'array':
                foreach ($handle as $key => $value) {
                    $tmp[$key] = implode('', $pinyin->convert($value[$target]));
                }
                break;
            default :
                return false;
        }
        $oder == 'asc' ? asort($tmp) : arsort($tmp);
        $response = [];
        foreach ($tmp as $key => $value) {
            $response[] = $handle[$key];
        }
        return $response;
    }
}