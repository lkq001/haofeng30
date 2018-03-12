<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $table = 'member'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    // 所属分组
    public function getHasOneGroup()
    {
        return $this->hasOne('App\Model\MemberGroup', 'id', 'group_id');
    }
}
