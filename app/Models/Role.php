<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
//
//    public function assignPermission($permission)
//    {
//        return $this->permissions()->save($permission);
//    }
//
//    public function removePermission($permission)
//    {
//        return $this->permissions()->detach($permission);
//    }
//
//    public function hasPermission($permission)
//    {
//        return $this->permissions->contains('name', $permission);
//    }
//
   public function assignUser($user)
    {
        return $this->users()->save($user);
    }

    public function removeUser($user)
    {
        return $this->users()->detach($user);
    }

    public function hasUser($user)
    {
        return $this->users()->contains($user);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }




    //
}
