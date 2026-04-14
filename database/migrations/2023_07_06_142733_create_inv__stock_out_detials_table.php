<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvStockOutDetialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv__stock_out_detials', function (Blueprint $table) {
            $table->id();
            $table->integer('inv_stockout_id');
            $table->integer('supplier_id');
            $table->integer('product_id');
            $table->integer('unit_id');
            $table->integer('quantity');
            $table->integer('store_id');
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
        Schema::dropIfExists('inv__stock_out_detials');
    }
}
