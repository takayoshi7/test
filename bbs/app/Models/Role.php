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

trait ChangePermissions
{
    public function givePermissions(array $permissions)
    {
        $permissions = $this->getPermissions($permissions);
        if ($permissions->isEmpty()) return $this;

        foreach ($permissions as $perm) {
            if (!$this->hasPermission($perm->name)) {
                $this->permissions()->attach($perm->id);
            }
        }
        return $this;
    }

    public function removePermissions(array $permissions)
    {
        $permissions = $this->getPermissions($permissions);
	if ($permissions->isEmpty()) return $this;

        foreach ($permissions as $perm) {
            if ($this->hasPermission($perm->name)) {
                $this->permissions()->detach($perm->id);
            }
        }
        return $this;
    }

    public function refreshPermissions(array $permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissions($permissions);
    }

    protected function getPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }
}
