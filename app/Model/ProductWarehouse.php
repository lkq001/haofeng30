<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductWarehouse extends Model
{
    use SoftDeletes;
    protected $table = 'product_warehouse'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function getHasMany()
    {
        //return $this->hasOne('App\Model\UserCards', 'card_code', 'card_id');
        return $this->hasMany('App\Model\ProductThumb', 'product_id', 'id');
    }

    public function getHasOne()
    {
        return $this->hasOne('App\Model\ProductThumb', 'product_id', 'id');
    }
}
