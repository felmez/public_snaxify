<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = ['name', 'slug', 'permissions'];

    public function users(){
        return $this->belongsToMany('\App\User');
    }

    // TODO:
    // public function hasAccess(array $permissions)
    // {
    //         foreach($permissions as $permission){
    //             if($role->hasPermission($permission)){
    //                 return true;
    //             }
    //         }
    //         return false;
    // }
    // protected function hasPermission(string $permission)
    // {
    //     $permissions= json_decode($this->permissions, true);
    //     return $permission[$permission]??false;
    // }
}
