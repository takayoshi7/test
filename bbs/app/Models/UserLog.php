<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    // use HasFactory;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'user_logs';


    protected $fillable = [
        'user_id', 'ip_address', 'user_agent', 'session_id', 'access_url', 'operation', 'access_time'
    ];
}
