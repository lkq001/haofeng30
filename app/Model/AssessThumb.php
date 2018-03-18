<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessThumb extends Model
{
    use SoftDeletes;
    protected $table = 'assess_thumb'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

}
