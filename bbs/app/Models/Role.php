<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'roles';

    public function emp() {
        return $this->belongsToMany('App\Models\Emp');
        // return $this->belongsToMany(Authority::class, 'authorities_roles', 'role_id', 'authority_id');
    }

    public function hasAuthority(String $authority) {
    return (bool) $this->authorities->where('name', $authority)->count();
    }

}
