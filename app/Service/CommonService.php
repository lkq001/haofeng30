<?php
namespace App\Service;

use Validator;

class CommonService
{
    // 分析request请求,获取数据条件
    public function requestToArray($request)
    {
        // 声明一个数组,存储request 数据
        $requestArray = array();

        foreach ($request as $key => $value) {
            if (!is_null($value)) {
                $requestArray[$key] = $value;
            }
        }

        return $requestArray;
    }
}
