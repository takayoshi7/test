<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Kyslik\ColumnSortable\Sortable;//追記

class Dept extends Model
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'dept';

    // use Sortable;//追記
    // public $sortable = ['deptno','dname','loc'];//追記(ソートに使うカラムを指定
}
