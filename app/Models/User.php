<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password','team_id','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo('App\Models\Role','role_id');
    }

    public function teams(){
        return $this->belongsTo('App\Models\CRM\Team','team_id');
    }


    public function hasAbility($permissions){

        $role=$this->role;
        if(!$role){
            return false;
        }
    

    foreach($role->permissions as $permission){
        if(is_array($permissions) && in_array($permission , $permissions)){
            return true;
        }elseif(is_string($permissions) && strcmp($permissions,$permission)==0){
            return true;
        }

    }
    return false;
    
}
}
