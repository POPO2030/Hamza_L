<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceServicePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_service_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('invoice_details_id');
            $table->integer('final_deliver_order_id');
            $table->integer('work_order_id');
            $table->integer('service_item_id');
            $table->integer('service_id');
            $table->double('service_price');
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
        Schema::dropIfExists('invoice_service_prices');
    }
}
