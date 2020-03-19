<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionDetail extends Model
{
    public $incrementing = false;

    protected $table = 'transaction_details';

    protected $fillable = ['amount', 'base_price', 'meta_product', 'transaction_id', 'product_id', 'merchant_id', 'meta_merchant'];

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

     public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }
}