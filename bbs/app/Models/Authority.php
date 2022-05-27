<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'authorities';

    public function roles() {
        return $this->belongsToMany(Role::class, 'roles_authorities', 'authority_id', 'role_id');
    }
}
