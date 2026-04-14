<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvStockTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_stock_transfer_details', function (Blueprint $table) {
            $table->id();
            $table->integer('inv_stock_transfer_id');
            $table->integer('product_id');
            $table->integer('unit_id');
            $table->double('quantity');
            $table->integer('supplier_id');
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
        Schema::dropIfExists('inv_stock_transfer_details');
    }
}
