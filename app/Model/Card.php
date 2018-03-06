<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;
    protected $table = 'card'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function getOneThumb()
    {
        return $this->hasOne('App\Model\CardThumb', 'card_id', 'id');
    }

    public function getToMany()
    {
        return $this->hasMany('App\Model\CardThumb', 'card_id', 'id');
    }

    public function getHasOneContent()
    {
        return $this->hasOne('App\Model\CardContent', 'card_id', 'id');
    }
}
