<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stock extends Model
{
    public $incrementing = false;

    // protected $table = 'stocks';

    protected $fillable = ['stock', 'product_id'];

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
}