<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalDeliverDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_deliver_details', function (Blueprint $table) {
            $table->id();
            $table->integer('deliver_order_id');
            $table->integer('package_number');
            $table->integer('count');
            $table->integer('total');
            $table->integer('final_deliver_order_id');
            $table->string('notes')->nullable();
            $table->integer('receivable_id')->nullable();
            $table->integer('flag_inovice')->default(0);
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
        Schema::dropIfExists('final_deliver_details');
    }
}
