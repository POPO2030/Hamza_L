<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateFashionSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_fashion_samples', function (Blueprint $table) {
            $table->id('id');
            $table->integer('sample_id')->nullable();
            $table->integer('stage_id');
            $table->integer('product_id');
            // $table->integer('service_item_id')->nullable();
            $table->double('ratio')->nullable();
            $table->integer('resolution')->nullable();
            $table->integer('power')->nullable();
            $table->integer('time')->nullable();
            $table->string('note')->nullable();
            $table->integer('flag');
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
        Schema::dropIfExists('create_fashion_samples');
    }
}
