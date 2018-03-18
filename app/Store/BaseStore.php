<?php
namespace App\Store;

class BaseStore
{
    // 静态变量
    protected static $db;

    /**
     * 依赖注入
     *
     * BaseStore constructor.
     */
    public function __construct()
    {
        self::$db = app('db');
    }



}