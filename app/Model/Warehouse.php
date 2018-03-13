<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $table = 'warehouse'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];
}
