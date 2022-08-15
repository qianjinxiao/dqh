<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id');
            $table->string('file')->default('')->comment('附件')->nullable();
            $table->integer('project_id');
            $table->string('project_type')->default('');
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
        Schema::dropIfExists('water_plan');
    }
}
