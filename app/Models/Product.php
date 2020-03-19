<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public $incrementing = false;

    // protected $table = 'products';

    protected $fillable = ['name','type', 'type_of_product', 'price', 'merchant_id', 'size', 'post_status'];

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

    public function stock()
    {
        return $this->hasOne('App\Models\Stock');
    }

     public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
    }
}