<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('amount');
            $table->uuid('transaction_id');
            $table->foreign('transaction_id')
            ->references('id')->on('transactions')
            ->onDelete('cascade');
            $table->uuid('product_id');
            $table->json('meta_product');
            $table->uuid('merchant_id');
            $table->json('meta_merchant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
