<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('creator_id');
            $table->integer('creator_team_id');
            $table->integer('sample_stage_id');
            $table->integer('closed_by_id')->nullable();
            $table->integer('closed_team_id')->nullable();
            $table->string('status',30);
            $table->integer('sample_id');
            $table->string('receive_name',30)->nullable();
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
        Schema::dropIfExists('lab_activities');
    }
}
