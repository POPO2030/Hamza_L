<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateSamplesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_samples', function (Blueprint $table) {
            $table->id('id');
            $table->integer('sample_id');
            $table->integer('stage_id');
            // $table->integer('service_item_id');
            $table->integer('product_id');
            $table->double('ratio');
            $table->integer('degree');
            $table->double('water');
            $table->integer('time');
            $table->double('ph')->nullable();
            $table->string('note')->nullable();
            $table->integer('flag')->nullable();
            $table->integer('rec_index');
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
        Schema::drop('create_samples');
    }
}
