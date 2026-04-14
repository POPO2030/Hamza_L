<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_orders', function (Blueprint $table) {
            $table->id('id');
            $table->integer('work_order_id');
            $table->integer('product_id');
            $table->string('product_type');
            $table->integer('receipt_id');
            $table->integer('receive_id');
            $table->integer('customer_id');
            $table->string('status',30);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deliver_orders');
    }
}
