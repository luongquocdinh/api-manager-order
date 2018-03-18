<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('customer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->integer('user_id');
            $table->integer('amount');
            $table->integer('delivery_date');
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
