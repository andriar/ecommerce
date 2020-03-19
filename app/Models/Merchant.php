<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Merchant extends Model
{
    public $incrementing = false;

    // protected $table = 'merchants';

    protected $fillable = ['name', 'type', 'address', 'user_id'];

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

     public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}