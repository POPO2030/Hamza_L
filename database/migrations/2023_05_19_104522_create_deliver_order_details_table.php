<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('deliver_order_id');
            $table->integer('package_number');
            $table->integer('count');
            $table->integer('total');
            $table->integer('delivered_package')->default(0);
            $table->string('barcode');
            $table->integer('creator_id')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('deliver_order_details');
    }
}
