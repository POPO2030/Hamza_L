<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvStockControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_stock_controls', function (Blueprint $table) {
            $table->id();
            $table->integer('inv_stockinout_id');
            $table->integer('supplier_id');
            $table->integer('product_id');
            $table->integer('unit_id');
            $table->integer('quantity_out')->default('0');
            $table->integer('quantity_in')->default('0');          
            $table->integer('store_id');
            $table->integer('flag');
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
        Schema::dropIfExists('inv_stock_controls');
    }
}

