<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id('id');
            $table->integer('creator_id');
            $table->integer('creator_team_id');
            $table->integer('closed_by_id')->nullable();
            $table->integer('closed_team_id')->nullable();
            $table->string('status',30);
            $table->string('color_thread',30)->nullable();      // لون الخيط
            $table->integer('customer_id');
            $table->integer('receive_receipt_id');
            $table->integer('initial_product_count')->nullable();    // عدد مبدئى
            $table->integer('product_id');
            $table->integer('product_count')->default('0');
            $table->integer('product_weight')->default('0');  //الوزن الفعلى
            $table->integer('receivable_id')->nullable();
            $table->integer('place_id')->nullable();         //مكان الوجبة
            $table->string('barcode')->nullable();         
            $table->integer('is_production')->default('0');        //دخلت انتاج
            $table->integer('priority')->default('0');        
            $table->integer('fabric_id');        
            $table->integer('fabric_source_id');        
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
        Schema::drop('work_orders');
    }
}
