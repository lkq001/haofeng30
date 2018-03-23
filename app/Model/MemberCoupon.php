<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberCoupon extends Model
{
    use SoftDeletes;
    protected $table = 'member_coupon'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function getOneMember()
    {
        return $this->hasOne('App\Model\Member', 'uuid', 'uuid');
    }
}