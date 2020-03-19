<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    public $incrementing = false;

    // protected $table = 'transactions';

    protected $fillable = ['code', 'status', 'buyer_id', 'meta_buyer'];

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

    public function transactionDetails()
    {
        return $this->hasMany('App\Models\TransactionDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'buyer_id');
    }
}