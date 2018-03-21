<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teamwork extends Model
{
    use SoftDeletes;
    protected $table = 'teamwork'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function getOneProduct()
    {
        return $this->hasOne('App\Model\ProductWarehouse', 'id', 'product_warehouse_id');
    }

    public function getOneProductThumb()
    {
        return $this->hasOne('App\Model\ProductThumb', 'product_id', 'product_warehouse_id');
    }
}
