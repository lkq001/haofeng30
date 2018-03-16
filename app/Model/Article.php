<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $table = 'article'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];


    public function getOneArticleLists()
    {
        return $this->hasOne('App\Model\ArticleCategory', 'id', 'pid');
    }
}
