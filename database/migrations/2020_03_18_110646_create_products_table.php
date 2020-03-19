<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type');
            $table->enum('type_of_product', ['REWARD', 'NOT_REWARD'])->default('NOT_REWARD');
            $table->float('price');
            $table->string('size');
            $table->enum('post_status', ['ARCHIVE', 'POST'])->default('ARCHIVE');
            $table->uuid('merchant_id');
            $table->foreign('merchant_id')
            ->references('id')->on('merchants')
            ->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
