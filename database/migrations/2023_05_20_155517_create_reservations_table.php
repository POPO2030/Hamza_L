<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id');
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->string('model',55)->nullable();
            $table->string('color_thread',30)->nullable();
            $table->integer('initial_product_count');
            $table->date('reservation_date');
            $table->integer('receivable_id')->nullable();
            $table->string('status',30)->default('open');
            $table->string('note')->nullable();
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
        Schema::drop('reservations');
    }
}
