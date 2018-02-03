<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('order_product', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('product_id')->nullable();
            $table->string('name');
            $table->string('uom')->nullable();
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('amount');
            $table->string('note')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
