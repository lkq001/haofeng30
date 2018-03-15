<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    protected $table = 'banner'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function getOneBannerCategory()
    {
        return $this->hasOne('App\Model\BannerCategory', 'id', 'pid');
    }

}
