<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Emp extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'emp';
    protected $fillable = ['id','password','email','empno','ename','job','mgr','hiredate','sal','comm','deptno','img1','img2','role'];

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id'; // これを追記

    // use HasFactory, ModelHistoryTrait;

    public function role(){
        return $this->belongsTo('App\Models\Role', 'role', 'id');
    }

    public function hasRole(String|int $role) {
        return ($this->role->name == $role) || ($this->role->id == $role);
    }

    public function hasAuthority(String $authority) {
        return (bool) $this->role->authorities->where('ename', $authority)->count();
    }

}
