<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvStockTransfersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv__stock_transfers', function (Blueprint $table) {
            $table->id('id');
            $table->string('serial');
            $table->integer('store_out');
            $table->integer('store_in')->default('0');
            $table->text('comment');
            $table->integer('user_id');
            $table->integer('updated_by')->nullable();
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
        Schema::drop('inv__stock_transfers');
    }
}
