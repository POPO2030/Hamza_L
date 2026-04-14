<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabSamplesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_samples', function (Blueprint $table) {
            $table->id('id');
            $table->integer('creator_id');
            $table->integer('creator_team_id');
            $table->integer('closed_by_id')->nullable();
            $table->integer('closed_team_id')->nullable();
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->string('serial')->nullable();
            $table->integer('count');
            $table->integer('sample_original_count')->nullable();
            $table->longtext('img')->nullable();
            $table->string('note')->nullable();
            $table->string('status',30);
            $table->string('receivable_name',30)->nullable();
            $table->dateTime('date_progressing')->comment('تاريخ تشغيل العينة بالمعمل')->nullable();
            $table->dateTime('date_finish')->comment('تاريخ الاستلام من المعمل')->nullable();
            $table->dateTime('date_deliver')->comment('تاريخ تسليم العينة للعميل')->nullable();
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
        Schema::drop('lab_samples');
    }
}
