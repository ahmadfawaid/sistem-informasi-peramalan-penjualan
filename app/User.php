<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nama', 'username', 'email', 'role', 'status', 'password'];
    protected $hidden = ['password', 'remember_token'];
    public $timestamps = false;

    public function hasRole($role){
    	if($this->role == $role){
            return true;
        }
        return false;
    }
}
