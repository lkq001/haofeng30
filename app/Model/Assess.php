<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assess extends Model
{
    use SoftDeletes;
    protected $table = 'assess'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function getContent()
    {
        return $this->hasOne('App\Model\AssessContent', 'assess_id', 'id');
    }

    public function getThumbs()
    {
        return $this->hasMany('App\Model\AssessThumb', 'assess_id', 'id');
    }

}
