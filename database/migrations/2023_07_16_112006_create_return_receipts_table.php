<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnReceiptsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_receipts', function (Blueprint $table) {
            $table->id('id');
            $table->string('model',55)->nullable();
            $table->string('brand',55)->nullable();
            $table->longtext('img')->nullable();
            $table->double('initial_count')->nullable();
            $table->double('final_weight')->nullable();
            $table->double('final_count')->nullable();
            $table->integer('product_id');
            $table->integer('customer_id');
            $table->integer('receivable_id');
            $table->integer('workOrder_id');
            $table->longtext('note')->nullable();
            $table->string('status')->nullable();
            $table->integer('creator_id')->nullable();
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
        Schema::drop('return_receipts');
    }
}
