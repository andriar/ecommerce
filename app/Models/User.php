<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable;
    
    public $incrementing = false;

    protected $fillable = ['name', 'email', 'password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
         parent::boot();
         self::creating(function($model){
             $model->id = self::generateUuid();
         });
    }
    public static function generateUuid()
    {
         return (string) Str::uuid();
    }

    public function rewardpoint()
    {
        return $this->hasOne('App\Models\RewardPoint', 'user_id');
    }

      public function merchant()
    {
        return $this->hasOne('App\Models\Merchant', 'user_id');
    }
}