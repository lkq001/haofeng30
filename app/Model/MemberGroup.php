<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroup extends Model
{
    use SoftDeletes;
    protected $table = 'member_group'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];
}
