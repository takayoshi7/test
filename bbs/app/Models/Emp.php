<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Emp extends Authenticatable
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'emp';

    public function role(){
        return $this->belongsTo('App\Models\Role', 'role', 'id');
        // return $this->belongsTo(Role::class);
    }

    public function hasRole(String|int $role) {
        return ($this->role->name == $role) || ($this->role->id == $role);
    }

    public function hasAuthority(String $authority) {
        return (bool) $this->role->authorities->where('name', $authority)->count();
    }
}
