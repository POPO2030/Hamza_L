<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDyeingReceivesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dyeing_receives', function (Blueprint $table) {
            $table->id('id');
            $table->string('unique_key');
            $table->string('customer_name');
            $table->integer('customer_id')->nullable();
            $table->string('model');
            $table->string('cloth_name');
            $table->string('product_name');
            $table->integer('product_color_id');
            $table->integer('dyeing_requests_id');
            $table->integer('quantity');
            $table->string('note_elsham1')->nullable();
            $table->string('note_elsham2')->nullable();
            $table->string('status',50)->default('open');
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
        Schema::drop('dyeing_receives');
    }
}
