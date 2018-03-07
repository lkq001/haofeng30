<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubWarehouseProduct extends Model
{
    use SoftDeletes;
    protected $table = 'product_sub_warehouse_product'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];
}
