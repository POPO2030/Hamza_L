<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks_details', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_id');
            $table->integer('customer_id');
            $table->string('date_in')->comment('تاريخ استلام الشيك')->nullable();
            $table->string('date_entitlment')->comment('تاريخ استحقاق الشيك')->nullable();
            $table->string('number_check')->nullable();
            $table->double('amount')->nullable();
            $table->longtext('img')->comment('صورة الشيك')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('banks_details');
    }
}
