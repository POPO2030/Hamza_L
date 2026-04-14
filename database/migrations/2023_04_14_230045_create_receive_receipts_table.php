<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveReceiptsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_receipts', function (Blueprint $table) {
            $table->id('id');
            $table->string('model',55)->nullable();
            $table->string('brand',55)->nullable();
            $table->longtext('img')->nullable();
            $table->double('initial_weight')->nullable();
            $table->double('initial_count');
            $table->double('final_weight')->nullable();
            $table->double('final_count')->nullable();
            $table->integer('product_id');
            $table->string('product_type');
            $table->integer('customer_id');
            $table->string('status')->nullable();
            $table->string('is_workOreder');
            $table->integer('receivable_id');
            $table->integer('creator_id')->nullable();
            $table->integer('updated_by')->nullable();
            $table->longText('note')->nullable();
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
        Schema::drop('receive_receipts');
    }
}
